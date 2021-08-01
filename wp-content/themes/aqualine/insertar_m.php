<?php
include "conexion.php";
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
    $hoy = date("Y-m-d H:i:s"); 
	$sql2=$wpdb->insert(
		'wp_posts',
		array(
			'post_title'=>$n,
			'post_content'=>$d,
            'post_date'=>$hoy,
            'post_date_gmt'=>$hoy,
            'post_modified'=>$hoy,
            'post_modified_gmt'=>$hoy,

		)
	);
    
	if($sql2 == true){
		echo '<script>alert("GUARDADO Producto")</script>';
    }else{
        echo '<script>alert("No se Guardo")</script>';
    }
    
    $id = "SELECT MAX(id) AS id FROM wp_posts";
    
    echo $id;
    for($i=1; $i<=19; $i++ ){
        switch($i){
            case 1:
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_edit_last",
                                'meta_value'=>"1",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
                break;
            case 2:
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_edit_lock",
                                'meta_value'=>"1607438616:1",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
                break;
            case 3: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_regular_price",
                                'meta_value'=>$v,
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
                break;
            case 4: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"total_sales",
                                'meta_value'=>"0",
                            )
                );
            break;
            case 5: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_tax_status",
                                'meta_value'=>"taxable",
                            )
                );
            break;
            case 6: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_tax_class",
                                'meta_value'=>"",
                            )
                );
            break;
            case 7: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_manage_stock",
                                'meta_value'=>"no",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
            break;
            case 8: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_backorders",
                                'meta_value'=>"no",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
            break;
            case 9: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_sold_individually",
                                'meta_value'=>"no",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
            break;
            case 10: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"virtual",
                                'meta_value'=>"si",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
            break;
            case 11: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_downloadable",
                                'meta_value'=>"no",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
            break;
            case 12: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_download_limit",
                                'meta_value'=>"-1",
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
            break;
            case 13: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_download_expiry",
                                'meta_value'=>"-1",
                            )
                );
            break;
            case 14: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_stock",
                                'meta_value'=>"(NULL)",
                            )
                );
            break;
            case 15: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_stock_status",
                                'meta_value'=>"instock",
                            )
                );
            break;
            case 16: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_wc_average_rating",
                                'meta_value'=>"0",
                            )
                );
            break;
            case 17: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_wc_review_count",
                                'meta_value'=>"0",
                            )
                );
            break;
            case 18: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_product_version",
                                'meta_value'=>"4.7.1",
                            )
                );
            break;
            case 19: 
                $sql3=$wpdb->insert(
                    'postmeta',
                            array(
                                'post_id'=>$id,
                                'meta_key'=>"_price",
                                'meta_value'=>$v,
                            )
                );
                if($sql3 == true){
                    echo '<script>alert("GUARDADO Producto")</script>';
                }else{
                    echo '<script>alert("No se Guardo")</script>';
                }
            break;

        }
        
    }
}
?>