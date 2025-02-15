<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;
use File;
use \App\Models\Place;
use \App\Models\Country;
class Admin_CommandController extends Controller {
    
    public function index(){
        return view('admin.command.index', ['locale' => 'en']);
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
    
    private function addFilesToZip($zip, $source, $basePath){
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
    //open in blank
    public function php_info(){
        dd(phpinfo());
    }

    //verificar que la carpeta de proyecto tenga persmisos
    //sudo chown -R www-data:www-data /var/www/otherworlds
    public function git_pull(){
        // Define el comando para hacer git pull
        $command = 'cd /var/www/otherworlds && git pull origin main';

        // Ejecutar el comando
        exec($command, $output, $returnVar);

        // Verificar si el comando fue exitoso
        if ($returnVar === 0) {
            success_message('Command successful. ' . implode("\n", $output));
            Artisan::call('cache:clear');
        } else {
            error_message('Command error. ' . implode("\n", $output));
        }
        
        return redirect()->back();
    }

    public function sitemap(){
        $start_locale = app()->getLocale();
        $urls = [];
        foreach (config('translatable.locales') as $locale) {
            app()->setLocale($locale);

            //generate an url for each place
            $url = 'https://otherworlds.es/'.$locale.'/'.trans('otherworlds.places_slug', [], $locale);
            foreach (Place::all() as $place) {
                $urls[] = $url.'/'.$place->slug;
            }

            $url = 'https://otherworlds.es/'.$locale.'/'.trans('otherworlds.countries_slug', [], $locale);
            foreach (Country::has('places')->get() as $country) {
                $urls[] = $url.'/'.$country->name;
            }
        }
        app()->setLocale($start_locale);
        return response()->view('sitemap_template', compact('urls'))
        ->header('Content-Type', 'application/xml');
    }

    public function server() {
        // Información de la CPU
        $cpuLoad = shell_exec("uptime"); // Alternativa para obtener la carga de la CPU
        preg_match("/load average: ([\d.]+), ([\d.]+), ([\d.]+)/", $cpuLoad, $matchesLoad);
    
        $cpuLoadData = [
            'last1Min' => $matchesLoad[1] ?? 0,
            'last5Min' => $matchesLoad[2] ?? 0,
            'last15Min' => $matchesLoad[3] ?? 0
        ];
    
        $cpuCores = shell_exec("nproc"); // Número de núcleos de CPU
    
        // Verifica que `shell_exec` esté habilitado y que los comandos sean compatibles con tu entorno.
    
        // Uso de RAM
        $memInfo = file_get_contents("/proc/meminfo");
        preg_match("/MemTotal:\s+(\d+) kB/i", $memInfo, $matchesTotal);
        preg_match("/MemAvailable:\s+(\d+) kB/i", $memInfo, $matchesAvailable);
    
        $totalRam = ($matchesTotal[1] / 1024) / 1024; // Convertir a GB
        $availableRam = ($matchesAvailable[1] / 1024) / 1024; // Convertir a GB
        $usedRam = $totalRam - $availableRam; // En GB
    
        // Uso de disco
        $diskTotal = disk_total_space("/") / (1024 * 1024 * 1024); // Convertir a GB
        $diskFree = disk_free_space("/") / (1024 * 1024 * 1024); // Convertir a GB
        $diskUsed = $diskTotal - $diskFree;
    
        // Sesiones activas
        $sessionsPath = storage_path('framework/sessions');
        $activeSessions = count(glob("$sessionsPath/*")); // Contar archivos de sesión
    
        // Datos a enviar a la vista
        $data = [
            'locale' => 'en',
            'cpuLoad' => array_merge($cpuLoadData, ['cores' => (int)$cpuCores]),
            'ram' => [
                'total' => round($totalRam, 2), // Total de RAM en MB
                'used' => round($usedRam, 2), // RAM usada en MB
                'available' => round($availableRam, 2) // RAM disponible en MB
            ],
            'disk' => [
                'total' => round($diskTotal, 2), // Disco total en GB
                'used' => round($diskUsed, 2), // Disco usado en GB
                'free' => round($diskFree, 2) // Disco libre en GB
            ],
            'activeSessions' => $activeSessions
        ];
    
        
            return view('admin.server.index', $data);
        }
}
