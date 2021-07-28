<?php

if(isset($_POST['insert'])){

    global $wpdb;
    $n=$_POST['nombre'];
    $d=$_POST['descripcion'];
    $v=$_POST['valor'];
    $sql= $wpdb->insert(
        'membresias',
        array(
            'nombre'=>$n,
            'descripcion'=>$d,
            'valor'=>$v
		)
	);
	if($sql == true){
        echo '<script>alert("GUARDADO Membresia")</script>';
    }else{
        echo '<script>alert("No se Guardo")</script>';
    }
	$sql2=$wpdb->insert(
		'wp_posts',
		array(
			'post_title'=>$n,
			'post_content'=>$d,
		)
	);
    
	if($sql2 == true){
		echo '<script>alert("GUARDADO Producto")</script>';
    }else{
        echo '<script>alert("No se Guardo")</script>';
    }

}

get_footer();
?>