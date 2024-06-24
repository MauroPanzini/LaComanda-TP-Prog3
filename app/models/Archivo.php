<?php
class Archivo {
    function subirArchivo($request, $response, $args) {
        if (isset($_POST['submit'])) {

            $targetDir = "./uploads/";

            $targetFile = $targetDir . basename($_FILES["csvFile"]["name"]);

            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            
            //verificacion en middleware???
            if($fileType != "csv") {
                $response->getBody()->write("Error, solo se permiten archivos CSV.");
                return $response;
            }
        
            // Intentar subir el archivo - - - try catch??
            if (move_uploaded_file($_FILES["csvFile"]["tmp_name"], $targetFile)) {
                $response->getBody()->write("El archivo " . htmlspecialchars(basename($_FILES["csvFile"]["name"])) . " ha sido subido.");
                return $response;
            } else {
                $response->getBody()->write("Se produjo un error en la subida del archivo.");
                return $response;
            }
        } else {
            $response->getBody()->write("No se ha enviado ningún archivo.");
            return $response;
        }
    }

    function descargarArchivo($request, $response, $args) {

        $filename = "data_" . date('Ymd') . ".csv";
    
        // ejemplo de data
        $data = [
            ["Nombre", "Edad", "Correo Electrónico"],
            ["Juan Pérez", 28, "juan.perez@example.com"],
            ["Ana García", 34, "ana.garcia@example.com"],
            ["Carlos López", 40, "carlos.lopez@example.com"]
        ];
    
        // Configurar las cabeceras para forzar la descarga del archivo -- solo navegador, postman no se D:
        $response = $response
            ->withHeader('Content-Type', 'text/csv')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
    
        $output = fopen('php://output', 'w');
    
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
    
        fclose($output);
    
        return $response;
    }
}
