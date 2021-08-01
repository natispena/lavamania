<?php
/**
 * Template Name: crud membresias
 * @package aquiline
*/
get_header();
include "mostrar_m.php";
?>
<script>
jQuery(document).on('submit_success', function(event, response){read();});
function readd(){
$.get("/api/read.php", function(data){document.getElementById("membresias").innerHtml =data;
});
}
</script>
<table id='membresias'>
<tr>
	<td>id</td>
	<td>nombre</td>
	<td>descripcion</td>
	<td>valor</td>
	<td>Borrar</td>
	<td>Editar</td>
</tr>
<?php
    
    //mostrar tabla con los datos
   foreach($membresia as $mostrar){
?>
<tr>
    <td><?php echo $mostrar->id;?></td>
    <td><?php echo $mostrar->nombre;?></td>
    <td><?php echo $mostrar->descripcion;?></td>
    <td><?php echo $mostrar->valor;?></td>
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
					<form class="elementor-form" method="post" name="membresias" style="opacity: 1;">
			<input type="hidden" name="post_id" value="111">
			<input type="hidden" name="form_id" value="aa61263">
			<input type="hidden" name="referer_title" value="CrudMembrecia">

							<input type="hidden" name="queried_id" value="111">
			
			<div class="elementor-form-fields-wrapper elementor-labels-above">
								<div class="elementor-field-type-text elementor-field-group elementor-column elementor-field-group-nombre elementor-col-50 elementor-field-required elementor-mark-required">
					<label for="form-field-nombre" class="elementor-field-label">Nombre</label><input size="1" type="text" name="nombre" id="nombre" class="elementor-field elementor-size-xs  elementor-field-textual" placeholder="Nombre" required="required" aria-required="true" aria-invalid="false">				</div>
								<div class="elementor-field-type-number elementor-field-group elementor-column elementor-field-group-valor elementor-col-50 elementor-field-required elementor-mark-required">
					<label for="form-field-valor" class="elementor-field-label">valor</label><input type="number" name="valor" id="valor" class="elementor-field elementor-size-xs  elementor-field-textual" placeholder="valor" required="required" aria-required="true" min="" max="" aria-invalid="false">				</div>
								<div class="elementor-field-type-textarea elementor-field-group elementor-column elementor-field-group-descripcion elementor-col-50 elementor-field-required elementor-mark-required">
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
 
 echo $id;
include "insertar_m.php";
get_footer()
?>