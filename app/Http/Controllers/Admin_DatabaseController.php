<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;

class Admin_DatabaseController extends Controller {
    
    public function index(){
        return view('admin.database.index', ['locale' => 'en']);
    }

    public function download(){
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $filename = env('APP_NAME')."-backup-" . date('Y-m-d_H-i-s') . ".sql";

        // Generar el comando mysqldump
        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > " . storage_path("app/{$filename}");

        // Ejecutar el comando
        $process = Process::fromShellCommandline($command);
        $process->run();

        // Verificar si el proceso fue exitoso
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Retornar el archivo como descarga y eliminarlo después de enviar
        return response()->download(storage_path("app/{$filename}"))->deleteFileAfterSend(true);
    }

    public function upload(Request $request){
        // Validar el archivo subido
        $request->validate([
            'backup' => 'required|file|mimes:sql,txt',
        ]);

        // Guardar el archivo SQL subido temporalmente
        $filePath = $request->file('backup')->storeAs('backups', 'uploaded_backup.sql');

        // Obtener las credenciales de la base de datos desde el archivo .env
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        // Comando para restaurar la base de datos usando el archivo SQL
        $command = "mysql --user={$username} --password={$password} --host={$host} {$database} < " . storage_path("app/{$filePath}");

        // Ejecutar el comando
        $process = Process::fromShellCommandline($command);
        $process->run();

        // Verificar si el proceso fue exitoso
        if (!$process->isSuccessful()) {
            // Eliminar el archivo en caso de error
            Storage::delete($filePath);
            throw new ProcessFailedException($process);
        }

        // Eliminar el archivo temporal después de restaurar
        Storage::delete($filePath);

        // Redirigir con un mensaje de éxito
        success_message('Backup cargado y ejecutado correctamente');
        return redirect()->back();
    }
    public function places_folder()
    {
        $zip = new ZipArchive();
        $fileName = 'places_backup.zip';
        $filePath = public_path('places');
    
        // Crear el archivo ZIP
        if ($zip->open(public_path($fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Recorrer todos los archivos y subdirectorios en el directorio 'places'
            $this->addFilesToZip($zip, $filePath, 'places');
            $zip->close();
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo ZIP.'], 500);
        }
    
        // Devolver el archivo ZIP para su descarga
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
    }
    
    private function addFilesToZip($zip, $source, $basePath)
    {
        $files = File::allFiles($source);
        
        foreach ($files as $file) {
            // Añadir el archivo al ZIP, manteniendo la estructura de carpetas
            $zip->addFile($file->getRealPath(), $basePath . '/' . $file->getRelativePathname());
        }
    
        // Recorrer los subdirectorios
        $directories = File::directories($source);
        foreach ($directories as $directory) {
            // Llamar recursivamente para añadir archivos de subdirectorios
            $this->addFilesToZip($zip, $directory, $basePath . '/' . basename($directory));
        }
    }

    public function php_info(){
        dd(phpinfo());
    }

public function git_pull()
{
    // Define el comando para hacer git pull
    $command = 'cd /var/www/otherworlds && git pull origin main';

    // Ejecutar el comando
    exec($command, $output, $returnVar);

    // Verificar si el comando fue exitoso
    if ($returnVar === 0) {
        return response()->json(['success' => 'App updated successfully.', 'output' => $output]);
    } else {
        return response()->json(['error' => 'Failed to update the repository.', 'output' => $output], 500);
    }
}
}
