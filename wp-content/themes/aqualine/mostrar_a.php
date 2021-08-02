<?php
include "conexion.php";
$sentencia=$bd->query("SELECT * FROM automoviles;");
$automovil= $sentencia->fetchAll(PDO::FETCH_OBJ);



?>