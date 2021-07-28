<?php
    $contrasena='';
    $usuario='root';
    $nombredb='lavamania';

    try{
        $bd = new PDO(
            'mysql:host=localhost;
            dbname='.$nombredb, $usuario, $contrasena

        );
    }catch(Exception $e){
        echo "error de conexion".$e->getMessage();
}
?>