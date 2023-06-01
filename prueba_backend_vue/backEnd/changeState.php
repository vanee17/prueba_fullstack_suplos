<?php
// Conexión a la base de datos
include_once '../config/db.php';
$obj = new db();
$conn = $obj->connection();
header("Access-Control-Allow-Origin: *");

// Obtener la fecha actual del servidor
$fechaActual = date('Y-m-d');
$horaActual = date('HH:mm:ss');
// Consulta SQL para seleccionar los registros con fecha_inicio menor que la fecha actual
// $sql = "SELECT id, fecha_inicio FROM clasificador.eventos WHERE fecha_inicio <= '$fechaActual' AND hora_inicio <= '$horaActual' AND  fecha_cierre > '$fechaActual' AND hora_cierre > '$horaActual'"; //publicado
$sql = "SELECT * FROM clasificador.eventos WHERE fecha_inicio <= CURRENT_DATE() AND fecha_cierre > CURRENT_DATE()"; //publicado
$result1 = $conn->query($sql);
$sql = "SELECT * FROM clasificador.eventos WHERE fecha_inicio <= CURRENT_DATE() AND fecha_cierre <= CURRENT_DATE() AND hora_cierre <= CURRENT_TIME() AND fecha_inicio < fecha_cierre AND hora_inicio < hora_cierre;"; // evaluacion
$result2 = $conn->query($sql);

if ($result1->rowCount() > 0) {
    while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
        $id = $row["id"];
        $updateSql = "UPDATE clasificador.eventos SET estado = 'publicado' WHERE id = '$id'";
        if ($conn->query($updateSql) === TRUE) {
            echo true;
        } else {
            echo "no se realiza actualización";
        }
    }
}

if($result2->rowCount() > 0){
    while ($row = $result2->fetch(PDO::FETCH_ASSOC)) {
        $id = $row["id"];
        $updateSql = "UPDATE clasificador.eventos SET estado = 'evaluacion' WHERE id = '$id'";
        if ($conn->query($updateSql) === TRUE) {
            echo true;
        } else {
            echo false;
        }
    }
}else {
    echo "No se encontraron registros que cumplan la condición";
}
// Esperar 1 segundo antes de la próxima ejecución
$conn = null; // Cerrar la conexión PDO