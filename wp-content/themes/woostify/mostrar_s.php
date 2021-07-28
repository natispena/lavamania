<?php
include "conexion.php";
$sentencia=$bd->query("SELECT * FROM servicios;");
$servicio= $sentencia->fetchAll(PDO::FETCH_OBJ);



?>