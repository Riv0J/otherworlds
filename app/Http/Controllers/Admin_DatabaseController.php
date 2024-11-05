<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

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
}
