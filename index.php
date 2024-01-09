<?php
require 'functions.php';

// Variable para almacenar el mensaje de alerta
$alertMessage = '';

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recopila los datos del formulario
    $name = $_POST['name'];
    $alias = $_POST['alias'];
    $rut = $_POST['rut'];
    $email = $_POST['email'];
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    $candidato = $_POST['candidato'];

    // Recopila las fuentes de información desde los checkboxes (pueden ser múltiples)
    if (isset($_POST['fuente']) && is_array($_POST['fuente'])) {
        $fuentes = implode(", ", $_POST['fuente']);
    } else {
        $fuentes = "";
    }

    // Realiza la inserción en la base de datos
    $conf = new Configuracion();
    $conf->conectarBD();

    // Inserta los datos en la tabla de votos
    $query = "INSERT INTO votos (nombre, alias, rut, email, id_region, id_city, id_candidato, fuentes) VALUES ('$name', '$alias', '$rut', '$email', '$region', '$comuna', '$candidato', '$fuentes')";

    try {
        $conf->actualizacion($query);
        // Si llega aquí, la inserción fue exitosa
        $alertMessage = "¡Voto registrado exitosamente!";
    } catch (Exception $e) {
        // En caso de error, muestra un mensaje de error
        $alertMessage = "Hubo un error al guardar los datos. Por favor, inténtalo de nuevo. Detalles: " . $e->getMessage();
    }
    
    echo '<script>';
    echo 'alert("' . $alertMessage . '");';
    echo 'window.location.href = "index.php";';
    echo '</script>';

    $conf->desconectarDB();

} else {
    // Si no se envió el formulario por POST, no hace falta hacer nada
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Votacion</title>
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <div class="container">
        <h2>Formulario de Votación</h2>
        <?php if (!empty($alertMessage)): ?>
            <script>alert("<?php echo $alertMessage; ?>");</script>
        <?php endif; ?>
        <form action="/" method="post" id="miFormulario">
            <!---- NOMBRE Y APELLIDO ---->
            <br><label for="name">Nombre y Apellido:</label>
            <input type="text" id="name" name="name" autocomplete="off"><br>
            <!---- NOMBRE Y APELLIDO ---->

            <!---- ALIAS ---->
            <br><label for="alias">Alias:</label>
            <input type="text" id="alias" name="alias" autocomplete="off"><br>
            <!---- ALIAS ---->

            <!---- RUT ---->
            <br><label for="rut">RUT:</label>
            <input type="text" id="rut" name="rut" autocomplete="off"><br>
            <!---- RUT ---->

            <!---- EMAIL ---->
            <br><label for="email">Email:</label>
            <input type="email" id="email" name="email" autocomplete="off"><br><br>
            <!---- EMAIL ---->

            <!---- REGION ---->
            <br><label for="region">Región:</label>
            <select id="id_region" name="region">
                <option value="">Selecciona una región</option>
                <?php
                $conf = new Configuracion();
                $conf->conectarBD();
                $consulta = "SELECT id_region,name FROM regions";
                $rst1 = $conf->consulta($consulta);
                for ($i = 0; $i < count($rst1); $i++) {
                    echo '<option value="' . $rst1[$i]["id_region"] . '">' . $rst1[$i]["name"] . '</option>';
                }
                $conf->desconectarDB();
                ?>
            </select><br>
            <!---- REGION ---->

            <!---- COMUNA ---->
            <br><label for="comuna">Comuna:</label>
            <select id="id_city" name="comuna">
                <option value="">Selecciona una comuna</option>
            </select><br>
            <!---- COMUNA ---->

            <!---- CANDIDATO ---->
            <br><label for="candidato">Candidato:</label>
            <select id="candidato" name="candidato">
                <option value="">Selecciona un candidato</option>
                <?php
                $conf = new Configuracion();
                $conf->conectarBD();
                $consulta = "SELECT id_candidato,nombre,apellido FROM candidatos";
                $rst1 = $conf->consulta($consulta);
                for ($i = 0; $i < count($rst1); $i++) {
                    echo '<option value="' . $rst1[$i]["id_candidato"] . '">' . $rst1[$i]["nombre"] . " " . $rst1[$i]["apellido"] . '</option>';
                }
                $conf->desconectarDB();
                ?>
            </select><br>
            <!---- CANDIDATO ---->

            <!---- CHECKBOX ---->
            <label>Cómo se enteró de nosotros:</label>
            <input type="checkbox" id="web" name="fuente[]" value="web">
            <label for="web">Web</label>

            <input type="checkbox" id="tv" name="fuente[]" value="tv">
            <label for="tv">TV</label>

            <input type="checkbox" id="redes" name="fuente[]" value="redes">
            <label for="redes">Redes Sociales</label>

            <input type="checkbox" id="amigo" name="fuente[]" value="amigo">
            <label for="amigo">Amigo</label><br>
            <!---- CHECKBOX ---->

            <br><input type="submit" value="Votar">
        </form>

        <script>

        </script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="script.js"></script>
    </div>
</body>

</html>