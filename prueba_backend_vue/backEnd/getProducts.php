<?php 
include_once '../config/db.php';

$obj =  new db();
$conn = $obj->connection();
$_POST = json_decode(file_get_contents("php://input"), true);
header("Access-Control-Allow-Origin: *");

$sql = "SELECT b_nombre_producto FROM clasificador.bienes_y_beneficios WHERE 1 limit 100";
$res = $conn->prepare($sql);
$res->execute();
$row = $res->fetchAll(PDO::FETCH_ASSOC);
print json_encode($row, JSON_UNESCAPED_UNICODE);
$obj = NULL;

