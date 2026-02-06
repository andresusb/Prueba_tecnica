<?php

header("Content-Type: application/json");

require_once("../config/database.php");

$database = new Database();
$db = $database->conectar();

$data = json_decode(file_get_contents("php://input"));

$query = "INSERT INTO tareas 
(usuario_id, proyecto_id, descripcion, horas_trabajadas, fecha)
VALUES (?, ?, ?, ?, CURDATE())";

$stmt = $db->prepare($query);

$stmt->execute([
    $data->usuario_id,
    $data->proyecto_id,
    $data->descripcion,
    $data->horas
]);

echo json_encode(["mensaje" => "Tarea creada"]);
