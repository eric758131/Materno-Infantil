<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function backupBD()
    {
        set_time_limit(300);

        // Datos desde config/database.php (.env)
        $conexion  = config('database.connections.pgsql');

        $nombreBD  = $conexion['database'];
        $usuario   = $conexion['username'];
        $password  = $conexion['password'];
        $host      = $conexion['host'];
        $puerto    = $conexion['port'];

        // 👉 Carpeta específica donde quieres guardar los backups
        // C:\Users\COMPU\Desktop\Integrador Materrno Infantil\Sistema\materno_infantil\database\backup
        $rutaBackup = database_path('backup');   // equivalente a /database/backup dentro del proyecto

        // Si prefieres ABSOLUTO, también podrías hacer:
        // $rutaBackup = 'C:/Users/COMPU/Desktop/Integrador Materrno Infantil/Sistema/materno_infantil/database/backup';

        if (!file_exists($rutaBackup)) {
            mkdir($rutaBackup, 0777, true);
        }

        $nombreArchivo = "backup_" . date("Ymd_His") . ".sql";
        $rutaCompleta  = $rutaBackup . DIRECTORY_SEPARATOR . $nombreArchivo;

        // ⚠️ Ajusta esta ruta a tu instalación real de PostgreSQL
        $pgDumpPath = '"C:\\Program Files\\PostgreSQL\\17\\bin\\pg_dump.exe"';

        // Archivo temporal .pgpass
        $pgpassContent = "$host:$puerto:$nombreBD:$usuario:$password";
        $pgpassFile    = tempnam(sys_get_temp_dir(), 'pgpass_');
        file_put_contents($pgpassFile, $pgpassContent);
        putenv("PGPASSFILE=$pgpassFile");

        $comando = "$pgDumpPath -U $usuario -h $host -p $puerto -d $nombreBD -F p";

        $descriptores = [
            1 => ['pipe', 'w'], // STDOUT
            2 => ['pipe', 'w'], // STDERR
        ];

        $process = proc_open($comando, $descriptores, $pipes);

        if (is_resource($process)) {
            $salida  = stream_get_contents($pipes[1]);
            $errores = stream_get_contents($pipes[2]);

            fclose($pipes[1]);
            fclose($pipes[2]);

            $returnCode = proc_close($process);

            unlink($pgpassFile);

            if ($returnCode === 0 && !empty($salida)) {
                file_put_contents($rutaCompleta, $salida);
                return back()->with('success', "Backup generado correctamente en: $rutaCompleta");
            } else {
                $errores = mb_convert_encoding($errores, 'UTF-8', 'auto');
                return back()->with('error', "Error al generar el backup. Detalles: $errores");
            }
        }

        if (isset($pgpassFile) && file_exists($pgpassFile)) {
            unlink($pgpassFile);
        }

        return back()->with('error', "No se pudo iniciar el proceso de pg_dump.");
    }
}
