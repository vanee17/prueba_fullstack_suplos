<?php
include_once '../config/db.php';

$obj =  new db();
$conn = $obj->connection();
$_POST = json_decode(file_get_contents("php://input"), true);
header("Access-Control-Allow-Origin: *");

try {
  // Obtener la lista de archivos desde la base de datos
  $query = "SELECT d_id, d_nombre_archivo, eventos.objeto FROM clasificador.d_documentos LEFT JOIN clasificador.eventos ON d_documentos.d_bienes_beneficios_id = eventos.id";
  //SELECT d_id, d_nombre_archivo,  d_archivo,  eventos.objeto AS objeto FROM clasificador.d_documentos LEFT JOIN clasificador.eventos ON d_documentos.d_bienes_beneficios_id = eventos.id 
  $statement = $conn->query($query);
  $files = $statement->fetchAll(PDO::FETCH_ASSOC);

  // Si se proporciona un fileId, descargar el archivo correspondiente
  if (isset($_GET['d_id'])) {
    $fileId = $_GET['d_id'];
    $query = "SELECT d_id, d_nombre_archivo, d_type, d_archivo, d_bienes_beneficios_id FROM clasificador.d_documentos WHERE d_id = :d_id";
    $statement = $conn->prepare($query);
    $statement->bindParam(':d_id', $fileId);
    $statement->execute();
    $file = $statement->fetch(PDO::FETCH_ASSOC);
    // Enviar el archivo para su descarga
    header("Content-Type: " . $file['d_type']);
    header("Content-Disposition: attachment; filename=" . $file['d_nombre_archivo'] . "");
    echo $file['d_archivo'];
    exit();
  }
  // Devolver la lista de archivos en formato JSON
  echo json_encode($files);

} catch (PDOException $e) {
  echo 'Error al conectar con la base de datos: ' . $e->getMessage();
}