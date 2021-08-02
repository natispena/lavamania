<?php

if(isset($_POST['insert'])){

    global $wpdb;
    $p=$_POST['placa'];
    $m=$_POST['marca'];
    $c=$_POST['color'];
    $t=$_POST['tipo'];
    $a=$_POST['ano'];
    $sql= $wpdb->insert(
        'automoviles',
        array(
            'placa'=>$p,
            'marca_id'=>$m,
            'color'=>$c,
            'vehiculo_id'=>$t,
            'ano'=>$a,
        )
    );

    if($sql == true){
        echo '<script>alert("GUARDADO")</script>';
    }else{
        echo '<script>alert("No se Guardo")</script>';
    }
}

?>