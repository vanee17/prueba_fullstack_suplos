<?php
include '../config/db.php';
$_POST = json_decode(file_get_contents("php://input"), true);
// Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Origin: *');

// Permitir los métodos GET, POST y OPTIONS
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Permitir las cabeceras Content-Type y Authorization
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Declarar las variables y asignarles un valor predeterminado
$objeto = "";
$descripcion = "";
$moneda = "";
$presupuesto = "";
$actividad = "";
$fecha1 = "";
$fecha2 = "";
$hora1 = "";
$hora2 = "";
// Verificar si las variables están definidas en $_POST
if(isset($_POST["objeto"]) && isset($_POST["date1"])){
    $objeto = $_POST["objeto"];
    $descripcion = $_POST["descripcion"];
    $moneda = $_POST["select"];
    $presupuesto = $_POST["presupuesto"];
    $actividad = $_POST["selectedItem"]["b_nombre_producto"];
    $fecha2 = $_POST['date2'];
    $hora1 = $_POST['start'];
    $hora2 = $_POST['end'];
}

$fecha1 = DateTime::createFromFormat('Y-m-d', $_POST['date1']);
$fecha1Formatted = $fecha1->format('Y-m-d'); // Obtener la representación formateada de la fecha
$obj = new db();
$conn = $obj->connection();
// Preparar la consulta SQL para insertar los datos en la tabla
$sql = "INSERT INTO clasificador.eventos (objeto, descripcion, moneda, presupuesto, actividad, fecha_inicio, fecha_cierre, hora_inicio, hora_cierre)
    VALUES ('$objeto', '$descripcion', '$moneda', '$presupuesto', '$actividad', '$fecha1Formatted', '$fecha2', '$hora1', '$hora2')";
$res = $conn->prepare($sql);
//Ejecutar la consulta
if ($res->execute()) {
    echo 1;
} else {
    echo "Error al guardar los datos: " . $conn->error;
}