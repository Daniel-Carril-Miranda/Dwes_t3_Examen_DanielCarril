<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Añadir Nueva Taquilla</title>
</head>
<body>
    <h2>Añadir Nueva Taquilla</h2>
    <form action="nueva_taquilla.php" method="post">
        <label for="localidad">Localidad:</label><br>
        <select id="localidad" name="localidad" required>
            <option value="">Seleccione una localidad</option>
            <option value="Gijon">Gijón</option>
            <option value="Oviedo">Oviedo</option>
            <option value="Aviles">Avilés</option>
        </select><br>
       
        <label for="direccion">Dirección:</label><br>
        <input type="text" id="direccion" name="direccion" required><br>
       
        <label for="capacidad">Capacidad:</label><br>
        <input type="number" id="capacidad" name="capacidad" min="1" required><br>
       
        <label for="ocupadas">Taquillas Ocupadas:</label><br>
        <input type="number" id="ocupadas" name="ocupadas" min="0" required><br>
       
        <input type="submit" value="Añadir Taquilla">
    </form>
</body>
</html>
 
 
<?php
    require_once 'connection.php';
    $conexion = conectarBD();
 
    /////////////////////////////////////////////////
    // TODO 1: Guardar la info en la base de datos. //
    /////////////////////////////////////////////////
 
   
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $localidad = $_POST['localidad'];
    $direccion = $_POST['direccion'];
    $capacidad = $_POST['capacidad'];
    $ocupadas = $_POST['ocupadas'];
 
    $consulta = $conexion->prepare("INSERT INTO PuntosDeRecogida (localidad, direccion, capacidad, ocupadas) VALUES (?, ?, ?, ?)");
 
    $consulta->bindParam(1, $localidad);
    $consulta->bindParam(2, $direccion);
    $consulta->bindParam(3, $capacidad);
    $consulta->bindParam(4, $ocupadas);
 
    if ($consulta->execute()) {
        echo "Nueva taquilla añadida con éxito.";
    } else {
        echo "Error al añadir la taquilla.";
    }
}
?>
