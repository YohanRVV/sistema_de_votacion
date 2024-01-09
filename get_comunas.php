<?php
include 'functions.php';

$id_region = filter_input(INPUT_POST, 'id_region');

$conf = new Configuracion();
$conf->conectarBD();

$consulta = "SELECT id_city,name FROM cities WHERE id_region = $id_region";
$datos = $conf->consulta($consulta);

$conf->desconectarDB();

if (count($datos) == 0) {
    echo '<option value="0">No hay registros en esta comuna</option>';
}

for ($i = 0; $i < count($datos); $i++) {
    echo '<option value="' . $datos[$i]["id_city"] . '">' . $datos[$i]["name"] . '</option>';

}

?>