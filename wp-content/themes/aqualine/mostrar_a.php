<?php
include "conexion.php";
$sentencia=$bd->query("SELECT * FROM automovils;");
$automovil= $sentencia->fetchAll(PDO::FETCH_OBJ);



?>