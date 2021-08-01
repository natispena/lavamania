<?php
include "conexion.php";
$sentencia=$bd->query("SELECT * FROM valores;");
$valor= $sentencia->fetchAll(PDO::FETCH_OBJ);

?>