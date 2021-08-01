<?php
/**
 * Template Name: buscador placas
 * @package aquiline
*/
$mysqli= new mysqli('localhost', 'root','', 'lavamania');
if ($mysqli->connect_error) {
    die("la conexión ha fallado: " . $mysqli->connect_error);
}
get_header();
?>
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
