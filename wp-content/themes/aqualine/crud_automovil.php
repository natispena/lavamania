<?php
/**
 * Template Name: crud automovil
 * * @package aquiline
*/
get_header();

include "mostrar_a.php";
?>

<script>
jQuery(document).on('submit_success', function(event, response){read();});
function readd(){
$.get("/api/read.php", function(data){document.getElementById("crud automovil").innerHtml =data;
});
}
</script>
<table id='automovil'>
<tr>
	<td>id</td>
	<td>placa</td>
	<td>marca</td>
	<td>color</td>
	<td>tipo</td>
	<td>año</td>
</tr>
<?php
    
    //mostrar tabla con los datos
   foreach($automovil as $mostrar)	{
?>
<tr>
    <td><?php echo $mostrar->id;?></td>
    <td><?php echo $mostrar->placa;?></td>
    <td><?php echo $mostrar->marca_id;?></td>
    <td><?php echo $mostrar->color;?></td>
    <td><?php echo $mostrar->vehiculo_id;?></td>
    <td><?php echo $mostrar->ano;?></td>
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
			<a href='http://localhost/lavamania/modificar-servicios?id=".$mostrar.[id]"' class="elementor-button-link elementor-button elementor-size-xs" role="button">
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
				
<article id="post-111" class="post-111 page type-page status-publish hentry">
			<div data-elementor-type="wp-page" data-elementor-id="111" class="elementor elementor-111" data-elementor-settings="[]">
							<div class="elementor-section-wrap">
							<section class="elementor-section elementor-top-section elementor-element elementor-element-3cb22a7 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="3cb22a7" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-7614cc5" data-id="7614cc5" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-d785e53 elementor-widget elementor-widget-heading" data-id="d785e53" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">AÑADIR NUEVO VEHICULO
</h2>		</div>
				</div>
					</div>
		</div>
							</div>
		</section>
				<section class="elementor-section elementor-top-section elementor-element elementor-element-97c71a4 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="97c71a4" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-71a7789" data-id="71a7789" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-ff33123 elementor-widget elementor-widget-html" data-id="ff33123" data-element_type="widget" data-widget_type="html.default">
				<div class="elementor-widget-container">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1.jquery.min.js"></script>
<script jquery(document).on('submit_success',="" function(event,="" response){read();});="" function="" readd(){="" $.get("="" api="" read.php",="" function(data){document.getelementbyid("membresias").innerhtml="data;" });="" }="">
</script>
<table id="membresias"></table>

<div class="elementor-form-fields-wrapper elementor-labels-above">
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-placa elementor-col-33 elementor-field-required">
					<label for="form-field-placa" class="elementor-field-label">placa</label><input size="1" type="text" name="placa" id="placa" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="placa" required="required" aria-required="true">				</div>
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-field_c5bd0e7 elementor-col-33 elementor-field-required">
					<label for="form-field-field_c5bd0e7" class="elementor-field-label">marca</label><input size="1" type="text" name="marca" id="marca" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="marca" required="required" aria-required="true">				</div>
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-field_93e4599 elementor-col-33 elementor-field-required">
					<label for="form-field-field_93e4599" class="elementor-field-label">color</label><input size="1" type="text" name="color" id="marca" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="color" required="required" aria-required="true">				</div>
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-field_59d4a33 elementor-col-33 elementor-field-required">
					<label for="form-field-field_59d4a33" class="elementor-field-label">tipo</label><input size="1" type="text" name="tipo" id="tipo" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="tipo" required="required" aria-required="true">				</div>
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-field_5595120 elementor-col-33 elementor-field-required">
					<label for="form-field-field_5595120" class="elementor-field-label">año</label><input size="1" type="text" name="ano" id="ano" class="elementor-field elementor-size-sm  elementor-field-textual" placeholder="año" required="required" aria-required="true">				</div>
								<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-50 e-form__buttons">
					<button type="submit" class="elementor-button elementor-size-sm btn btn-xs" aria-invalid="false" name="insert">
						<span>
															<span class="elementor-align-icon-left elementor-button-icon">
									<i aria-hidden="true" class="far fa-save"></i>																	</span>
																						<span class="elementor-button-text">Guardar</span>
													</span>
					</button>
					<span class="ltx-btn-overlay ltx-btn-overlay-top"></span><span class="ltx-btn-overlay ltx-btn-overlay-bottom"></span></button></span>
				</div>
			</div>

<?php
include "insertar_a.php";
get_footer();
?>