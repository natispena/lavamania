<?php

if(isset($_POST['insert'])){

    global $wpdb;
    $n=$_POST['nombre'];
    $d=$_POST['descripcion'];
    $sql= $wpdb->insert(
        'servicios',
        array(
            'nombre'=>$n,
            'descripcion'=>$d,
        )
    );

    if($sql == true){
        echo '<script>alert("GUARDADO")</script>';
    }else{
        echo '<script>alert("No se Guardo")</script>';
    }
}

?>