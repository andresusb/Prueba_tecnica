<?php

header("Content-Type: application/json");

require_once("../config/database.php");
require_once("../models/Tarea.php");

$database = new Database();
$db = $database->conectar();

$tarea = new Tarea($db);

if(isset($_GET["usuario_id"])) {

    $usuario_id = $_GET["usuario_id"];

    $resultado = $tarea->obtenerTareasPorUsuario($usuario_id);

    echo json_encode($resultado);

} else {

    echo json_encode(["error" => "Debe enviar usuario_id"]);

}
