<?php
include '../config/db.php';
$_POST = json_decode(file_get_contents("php://input"), true);
// Permitir solicitudes desde cualquier origen
header('Access-Control-Allow-Origin: *');
// Permitir los métodos GET, POST y OPTIONS
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// Permitir las cabeceras Content-Type y Authorization
header('Access-Control-Allow-Headers: Content-Type, Authorization');
$id_cerrada="";
$items ="";
$descripcion ="";
if(isset($_POST['id_cerrada'])){
    $id_cerrada = $_POST['id_cerrada'];
}
if(isset($_POST['select'])){
    $items = $_POST['select'];
}
if(isset($_POST['descripcion'])){
    $descripcion = $_POST['descripcion'];
}

$obj = new db();
$conn = $obj->connection();
// Construir la consulta SQL con los marcadores de posición
$sql = "SELECT * FROM clasificador.eventos WHERE 1=1 ";
// Construir las condiciones de búsqueda dinámicamente
$conditions = array();
$parameters = array();

if (!empty($id_cerrada)) {
    $conditions[] = "id = :id_cerrada";
    $parameters[':id_cerrada'] = $id_cerrada;
}

if (!empty($items)) {
    $conditions[] = "estado LIKE :items";
    $parameters[':items'] = '%' . $items . '%';
}

if (!empty($descripcion)) {
    $conditions[] = "(descripcion LIKE :descripcion OR objeto LIKE :descripcion)";
    $parameters[':descripcion'] = '%' . $descripcion . '%';
}
// Unir las condiciones con el operador lógico AND
if (!empty($conditions)) {
    $sql .= ' AND ' . implode(' AND ', $conditions);
}
// Preparar la consulta
$stmt = $conn->prepare($sql);
// Vincular los valores a los marcadores de posición
foreach ($parameters as $key => $value) {
    $stmt->bindValue($key, $value);
}
// Ejecutar la consulta
$stmt->execute();
// Obtener los resultados en un array asociativo
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Generar la tabla HTML con los datos obtenidos
print json_encode($resultados, JSON_UNESCAPED_UNICODE);