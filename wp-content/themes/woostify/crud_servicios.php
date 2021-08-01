<?php
/**
 * Template Name: crud servicios
 * @package woostify


*/

get_header();
include "menu.php";

include "mostrar_s.php";
?>

<script>
jQuery(document).on('submit_success', function(event, response){read();});
function readd(){
$.get("/api/read.php", function(data){document.getElementById("servicios").innerHtml =data;
});
}
</script>
<table id='servicios'>
<tr>
	<td>id</td>
	<td>nombre</td>
	<td>descripcion</td>
	<td>Borrar</td>
	<td>Editar</td>
</tr>
<?php
    
    //mostrar tabla con los datos
   foreach($servicio as $mostrar)	{
?>
<tr>
    <td><?php echo $mostrar->id;?></td>
    <td><?php echo $mostrar->nombre;?></td>
    <td><?php echo $mostrar->descripcion;?></td>
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
			<h2 class="elementor-heading-title elementor-size-default">AÑADIR NUEVOS SERVICIOS
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
<script jquery(document).on('submit_success',="" function(event,="" response){read();});="" function="" readd(){="" $.get("="" api="" read.php",="" function(data){document.getelementbyid("servicios").innerhtml="data;" });="" }="">
</script>
<table id="Servicios"></table>

		</div>
				</div>
					</div>
		</div>
							</div>
		</section>
				<section class="elementor-section elementor-top-section elementor-element elementor-element-615c3f7 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="615c3f7" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-d51e751" data-id="d51e751" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-aa61263 elementor-button-align-end elementor-widget elementor-widget-form" data-id="aa61263" data-element_type="widget" data-settings="{&quot;step_next_label&quot;:&quot;Next&quot;,&quot;step_previous_label&quot;:&quot;Previous&quot;,&quot;button_width&quot;:&quot;50&quot;,&quot;step_type&quot;:&quot;number_text&quot;,&quot;step_icon_shape&quot;:&quot;circle&quot;}" data-widget_type="form.default">
				<div class="elementor-widget-container">
					<form class="elementor-form" method="post" name="servicios" style="opacity: 1;">
			<input type="hidden" name="post_id" value="111">
			<input type="hidden" name="form_id" value="aa61263">
			<input type="hidden" name="referer_title" value="Crud">

							<input type="hidden" name="queried_id" value="111">
			
			<div class="elementor-form-fields-wrapper elementor-labels-above">
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-nombre elementor-col-50 elementor-field-required elementor-mark-required">
					<label for="form-field-nombre" class="elementor-field-label">Nombre</label><input size="1" type="text" name="nombre" id="nombre" class="elementor-field elementor-size-xs  elementor-field-textual" placeholder="Nombre" required="required" aria-required="true" aria-invalid="false">				</div>
								<div class="elementor-field-type-number elementor-field-group elementor-column elementor-field-group-valor elementor-col-50 elementor-field-required elementor-mark-required">
					<label for="form-field-descripcion" class="elementor-field-label">Descripcion</label><textarea class="elementor-field-textual elementor-field  elementor-size-xs" name="descripcion" id="descripcion" rows="4" placeholder="Descripcion" required="required" aria-required="true" aria-invalid="false"></textarea>				</div>
								<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-50 e-form__buttons">
					<button type="submit" class="elementor-button elementor-size-sm" aria-invalid="false" name="insert">
						<span>
															<span class="elementor-align-icon-left elementor-button-icon">
									<i aria-hidden="true" class="far fa-save"></i>																	</span>
																						<span class="elementor-button-text">Guardar</span>
													</span>
					</button>
				</div>
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
include "insertar_s.php";
get_footer();
?>