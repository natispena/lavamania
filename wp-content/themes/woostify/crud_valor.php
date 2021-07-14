<?php
/**
 * Template Name: crud valor
 * @package woostify
*/
$mysqli = new mysqli('localhost', 'root','', 'lavamania');

get_header();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1.jquery.min.js"></script>
<script>
jQuery(document).on('submit_success', function(event, response){read();});
function readd(){
$.get("/api/read.php", function(data){document.getElementById("valores").innerHtml =data;
});
}
</script>
<table id='valores'>
<tr>
	<td>id</td>
	<td>vehiculo_id</td>
	<td>servicio_id</td>
	<td>valor</td>
	<td>Borrar</td>
	<td>Editar</td>
</tr>
<?php
    
    //mostrar tabla con los datos
    $sql="SELECT * FROM valores";
	$result= mysqli_query($mysqli, $sql);
	while($mostrar=mysqli_fetch_array($result)){
?>
<tr>
    <td><?php echo $mostrar['id']?></td>
    <td><?php echo $mostrar['vehiculo_id']?></td>
    <td><?php echo $mostrar['servicio_id']?></td>
    <td><?php echo $mostrar['valor']?></td>
	<td><div class="elementor-element elementor-element-28ba169 elementor-button-danger elementor-widget elementor-widget-button" data-id="28ba169" data-element_type="widget" data-widget_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#" class="elementor-button-link elementor-button elementor-size-xs" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-icon elementor-align-icon-left">
				<i aria-hidden="true" class="far fa-trash-alt"></i>			</span>
						<span class="elementor-button-text"></span>
		</span>
					</a>
		</div>
				</div>
				</div></td>
	<td><div class="elementor-element elementor-element-cd82676 elementor-button-info elementor-align-center elementor-widget elementor-widget-button" data-id="cd82676" data-element_type="widget" data-widget_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#" class="elementor-button-link elementor-button elementor-size-xs" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-icon elementor-align-icon-right">
				<i aria-hidden="true" class="far fa-edit"></i>			</span>
						<span class="elementor-button-text"></span>
		</span>
					</a>
		</div>
				</div>
				</div>

	</tr>

<?php
	}  
?>
</table>
<div id="content" class="site-content" tabindex="-1">
		<div class="woostify-container">		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				
<article id="post-161" class="post-161 page type-page status-publish hentry">
			<div data-elementor-type="wp-page" data-elementor-id="161" class="elementor elementor-161" data-elementor-settings="[]">
							<div class="elementor-section-wrap">
							<section class="elementor-section elementor-top-section elementor-element elementor-element-9bf7595 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="9bf7595" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a59b3f0" data-id="a59b3f0" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-5fd78cc elementor-button-align-center elementor-widget elementor-widget-form" data-id="5fd78cc" data-element_type="widget" data-settings="{&quot;step_next_label&quot;:&quot;Next&quot;,&quot;step_previous_label&quot;:&quot;Previous&quot;,&quot;step_type&quot;:&quot;number_text&quot;,&quot;step_icon_shape&quot;:&quot;circle&quot;}" data-widget_type="form.default">
				<div class="elementor-widget-container">
					<form class="elementor-form" method="post" name="New Form">
			<input type="hidden" name="post_id" value="161"/>
			<input type="hidden" name="form_id" value="5fd78cc"/>
			<input type="hidden" name="referer_title" value="crudValor" />

							<input type="hidden" name="queried_id" value="161"/>

			<div class="elementor-form-fields-wrapper elementor-labels-above">
						<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-name elementor-col-33 elementor-field-required elementor-mark-required">
					<label for="form-field-vehiculo" class="elementor-field-label">Vehiculo</label><select size="1" type="number" name="vehiculo_id" id="vehiculo_id" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="Vehiculo"  >
					    <option value="0">Tipo:</option>
						<?php
						     $query = $mysqli -> query ("SELECT * FROM vehiculos");
							 while ($vehiculo= mysqli_fetch_array($query)) {
								echo '<option value="'.$vehiculo[id].'">'.$vehiculo[nombre].'</option>';
							}
						?>
					</select>
					</div>

					    <div class="elementor-field-type-servicio elementor-field-group elementor-column elementor-field-group-servicio elementor-col-33 elementor-field-required elementor-mark-required">
					<label for="form-field-servicio" class="elementor-field-label">Servicio</label><select size="1" type="number" name="servicio_id" id="servicio_id" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="servicio"  >
					<option value="0">Nombre:</option>
						<?php
						     $query = $mysqli -> query ("SELECT * FROM servicios");
							 while ($servicio = mysqli_fetch_array($query)) {
								echo '<option value="'.$servicio[id].'">'.$servicio[nombre].'</option>';
							}
						?>
					</select>
					</div>

					    <div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-valor elementor-col-33 elementor-field-required elementor-mark-required">
					<label for="form-field-valor" class="elementor-field-label">Valor</label><input size="1" type="text" name="form_fields[valor]" id="form-field-valor" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="valor" required="required" aria-required="true">				</div>
								<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100 e-form__buttons">
					<button type="submit" class="elementor-button elementor-size-md" name="insert">
						<span >
															<span class=" elementor-button-icon">
																										</span>
																						<span class="elementor-button-text">Guardar</span>
													</span>
					</button>
				</div>
			</div>
		</form>
				</div>
				</div>
					</div>
		</div>
							</div>
		</section>
						</div>
					</div>
		</article><!-- #post-## -->
			</main>
		</div>
	</div>		</div>


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

get_footer();
?>
