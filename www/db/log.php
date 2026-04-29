<?php
// La carpeta que esta log.php se genera el directorio logs
class log {
    private static function escribir_fich_log($mensaje, $nivel = "INFO") {
        $archivo = __DIR__ . "/logs/" . strtolower($nivel) . ".log";
        $ubicacion_de_logs = __DIR__ . "/logs";
        if (!file_exists($ubicacion_de_logs)) {
            mkdir($ubicacion_de_logs, 0777, true);
        }
        $fecha = date("Y-m-d H:i:s");
        $texto = $fecha . " - " . $mensaje;
        file_put_contents($archivo, $texto . PHP_EOL , FILE_APPEND);
    }

    public static function info($mensaje){
        self::escribir_fich_log($mensaje, "INFO");
    }
    
    public static function debug($mensaje){
        self::escribir_fich_log($mensaje, "DEBUG");
    }

    public static function error($mensaje){
        self::escribir_fich_log($mensaje, "ERROR");
    }
}
?>