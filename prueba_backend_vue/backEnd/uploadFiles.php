<?php 
include_once '../config/db.php';

$obj =  new db();
$conn = $obj->connection();
$data = json_decode(file_get_contents("php://input"), true);
header("Access-Control-Allow-Origin: *");

try {
  // Procesar los archivos
  $files = $_FILES['files'];
  
  for ($i = 0; $i < count($files['name']); $i++) {
    if ($files['error'][$i] === UPLOAD_ERR_OK) {
      $file = $files['tmp_name'][$i];
      $fileName = $files['name'][$i];
      $fileType = $files['type'][$i];  
      // Leer el contenido del archivo
      $content = file_get_contents($file);
      // Preparar la consulta SQL utilizando marcadores de posición
      $query = "INSERT INTO clasificador.d_documentos (d_nombre_archivo, d_archivo,d_type, d_bienes_beneficios_id) VALUES (:d_nombre_archivo, :d_archivo,:d_type, :d_bienes_beneficios_id)";
      $statement = $conn->prepare($query);
      $prueba = $_POST['id'];
      // Vincular los valores a los marcadores de posición
      $statement->bindParam(':d_nombre_archivo', $fileName);
      $statement->bindParam(':d_archivo',  $content, PDO::PARAM_LOB);
      $statement->bindParam(':d_bienes_beneficios_id', $prueba);
      $statement->bindParam(':d_type', $fileType);
      // Ejecutar la consulta preparada
      $statement->execute();
      echo 'Archivo ' . $fileName . ' subido y guardado en la base de datos.<br>';
    }else {
      echo 'Error al subir el archivo ' . $files['name'][$i] . '<br>';
    }
  }
  // Cerrar la conexión
  $conn = null;
} catch (PDOException $e) {
    echo 0;
}