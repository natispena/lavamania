<?php
include "conexion.php";
$sentencia=$bd->query("SELECT * FROM membresias;");
$membresia= $sentencia->fetchAll(PDO::FETCH_OBJ);

?>