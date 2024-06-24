<?php

class Archivo{

    function subirArchivo(){
        if (isset($_POST['submit'])) {
            // Directorio donde se guardará el archivo subido
            $targetDir = "uploads/";
            // Nombre del archivo subido
            $targetFile = $targetDir . basename($_FILES["csvFile"]["name"]);
            // Tipo de archivo (mime type)
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
            // Verificar si el archivo es un CSV
            if($fileType != "csv") {
                echo "Lo siento, solo se permiten archivos CSV.";
                exit();
            }
        
            // Intentar subir el archivo
            if (move_uploaded_file($_FILES["csvFile"]["tmp_name"], $targetFile)) {
                echo "El archivo " . htmlspecialchars(basename($_FILES["csvFile"]["name"])) . " ha sido subido.";
            } else {
                echo "Lo siento, hubo un error al subir tu archivo.";
            }
        } else {
            echo "No se ha enviado ningún archivo.";
        }
    
    }
    function descargarArchivo(){
            // Nombre del archivo CSV que se descargará
        $filename = "data_" . date('Ymd') . ".csv";
    
        // Crear un array con datos de ejemplo (puedes modificar esto con tus propios datos)
        $data = [
            ["Nombre", "Edad", "Correo Electrónico"],
            ["Juan Pérez", 28, "juan.perez@example.com"],
            ["Ana García", 34, "ana.garcia@example.com"],
            ["Carlos López", 40, "carlos.lopez@example.com"]
        ];
    
        // Configurar las cabeceras para forzar la descarga del archivo
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);
    
        // Abrir la salida para escribir el contenido del CSV
        $output = fopen('php://output', 'w');
    
        // Escribir cada fila de datos en el archivo CSV
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
    
        // Cerrar el flujo de salida
        fclose($output);
    }
}
?>
