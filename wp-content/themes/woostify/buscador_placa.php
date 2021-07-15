<?php
/**
 * Template Name: buscador placas
 * @package woostify
 */
$mysqli= new mysqli('localhost', 'root','', 'lavamania');
if ($mysqli->connect_error) {
    die("la conexión ha fallado: " . $mysqli->connect_error);
}
get_header();
?>
<section class="elementor-section elementor-top-section elementor-element elementor-element-36db429 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="36db429" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a6fb46e" data-id="a6fb46e" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-01cb563 elementor-nav-menu__align-center elementor-nav-menu--dropdown-tablet elementor-nav-menu__text-align-aside elementor-nav-menu--toggle elementor-nav-menu--burger elementor-widget elementor-widget-nav-menu" data-id="01cb563" data-element_type="widget" data-settings="{&quot;layout&quot;:&quot;horizontal&quot;,&quot;submenu_icon&quot;:{&quot;value&quot;:&quot;fas fa-caret-down&quot;,&quot;library&quot;:&quot;fa-solid&quot;},&quot;toggle&quot;:&quot;burger&quot;}" data-widget_type="nav-menu.default">
				<div class="elementor-widget-container">
						<nav migration_allowed="1" migrated="0" role="navigation" class="elementor-nav-menu--main elementor-nav-menu__container elementor-nav-menu--layout-horizontal e--pointer-underline e--animation-fade"><ul id="menu-1-01cb563" class="elementor-nav-menu" data-smartmenus-id="1626359005677065"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-146"><a href="http://localhost/lavamania/crudservicios/" class="elementor-item">Crud Servicios</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-152"><a href="http://localhost/lavamania/crud-membresias/" class="elementor-item">Crud membresias</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-159"><a href="http://localhost/lavamania/crud-valor/" class="elementor-item">Crud valor</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-176"><a href="http://localhost/lavamania/consulta-placa/" class="elementor-item">Consulta placa</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-180"><a href="http://localhost/lavamania/administrador/" tabindex="-1" class="elementor-item ">administrador</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-183"><a href="http://localhost/lavamania/modificar-servicios/" class="elementor-item">modificar servicios</a></li>
</ul></nav>
					<div class="elementor-menu-toggle" role="button" tabindex="0" aria-label="Menu Toggle" aria-expanded="false">
			<i class="eicon-menu-bar" aria-hidden="true" role="presentation"></i>
			<span class="elementor-screen-only">Menu</span>
		</div>
			<nav class="elementor-nav-menu--dropdown elementor-nav-menu__container" role="navigation" aria-hidden="true"><ul id="menu-2-01cb563" class="elementor-nav-menu" data-smartmenus-id="16263590056783948"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-146"><a href="http://localhost/lavamania/crudservicios/" class="elementor-item" tabindex="-1">Crud Servicios</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-152"><a href="http://localhost/lavamania/crud-membresias/" class="elementor-item" tabindex="-1">Crud membresias</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-159"><a href="http://localhost/lavamania/crud-valor/" class="elementor-item" tabindex="-1">Crud valor</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-176"><a href="http://localhost/lavamania/consulta-placa/" class="elementor-item" tabindex="-1">Consulta placa</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-180"><a href="http://localhost/lavamania/administrador/" tabindex="-1" class="elementor-item ">administrador</a></li>
<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-183"><a href="http://localhost/lavamania/modificar-servicios/" class="elementor-item" tabindex="-1">modificar servicios</a></li>
</ul></nav>
				</div>
				</div>
					</div>
		</div>
							</div>
		</section>
<form method="POST" action="" onSubmit="return validarForm(this)">

    <input type="text" placeholder="Buscar placa" name="palabra">

    <input type="submit" value="Buscar" name="buscar">

</form>
<script type="text/javascript">
    function validarForm(formulario)
    {
        if(formulario.palabra.value.length==0)
        { //¿Tiene 0 caracteres?
            formulario.palabra.focus();  // Damos el foco al control
            alert('Debes rellenar este campo'); //Mostramos el mensaje
            return false;
        } //devolvemos el foco
        return true; //Si ha llegado hasta aquí, es que todo es correcto
    }
</script>
<?php
if($_POST['buscar'])
{
    ?>
    <!-- el resultado de la búsqueda lo encapsularemos en un tabla -->
    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
        <tr>
            <!--creamos los títulos de nuestras dos columnas de nuestra tabla -->
            <td width="100" align="center"><strong>Propietario</strong></td>
            <td width="100" align="center"><strong>Placa</strong></td>
            <td width="100" align="center"><strong>Tipo Vehiculo</strong></td>
            <td width="100" align="center"><strong>Tipo Membresia</strong></td>


        </tr>
        <?php
        //obtenemos la información introducida anteriormente desde nuestro buscador PHP
        $buscar = $_POST["palabra"];
        /* ahora ejecutamos nuestra sentencia SQL, lo que hemos vamos a hacer es usar el
        comando like para comprobar si existe alguna coincidencia de la cadena insertada
        en nuestro campo del formulario con nuestros datos almacenados en nuestra base de
        datos, la cadena insertada en el buscador se almacenará en la variable $buscar */

        /* hemos usado también la sentencia or para indicarle que queremos que nos encuentre
        las coincidencias en alguno de los campos de nuestra tabla (placa o nombre del propietario),
        si hubiéramos puesto un and solo nos devolvería el resultado del filtro en el
        caso de cumplirse las dos condiciones */
        $sql="SELECT * FROM clientes WHERE placa like '%$buscar%' or nombreP like '%$buscar%'";
        $consulta_mysql= mysqli_query ($mysqli, $sql);

        while($registro = mysqli_fetch_array($consulta_mysql))
        {
            ?>
            <tr>
                <!--mostramos e l dato de las tuplas que han coincidido con la
                cadena insertada en nuestro formulario-->
                <td class="estilo-tabla" align="center"><?=$registro['nombreP']?></td>
                <td class=”estilo-tabla” align="center"><?=$registro['placa']?></td>
                <td class=”estilo-tabla” align="center"><?=$registro['vehiculo_id']?></td>
                <td class=”estilo-tabla” align="center"><?=$registro['membresia_id']?></td>
            </tr>
            <?php
        } //fin blucle
        ?>
    </table>
    <?php
} // fin if

get_footer();
?>
