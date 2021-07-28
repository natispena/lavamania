<?php

if(isset($_POST['insert'])){

    global $wpdb;
    $d=$_POST['vehiculo_id'];
    $s=$_POST['servicio_id'];
    $v=$_POST['valor'];
    $sql= $wpdb->insert(
        'valores',
        array(
            'vehiculo_id'=>$d,
            'servicio_id'=>$s,
            'valor'=>$v
        )
    );

    if($sql == true){
        echo '<script>alert("GUARDADO")</script>';
    }else{
        echo '<script>alert("No se Guardo")</script>';
    }
}
?>