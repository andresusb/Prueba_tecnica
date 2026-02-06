<?php

header("Content-Type: application/json");

require_once("../config/database.php");

$database = new Database();
$db = $database->conectar();

$query = "SELECT id, nombre FROM usuarios";

$stmt = $db->prepare($query);
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
