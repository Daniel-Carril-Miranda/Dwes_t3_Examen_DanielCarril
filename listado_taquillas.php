<?php
require "connection.php";
$conexion = conectarBD();

session_start();
 
$localidadSeleccionada = '';
if(isset($_SESSION['localidad'])) {
    
    $localidadSeleccionada = $_SESSION['localidad'];
} 
 

if(isset($_GET['localidad'])) {
    $localidadSeleccionada = $_GET['localidad'];
    $_SESSION['localidad'] = $localidadSeleccionada;
}
 
?>

<!DOCTYPE html>
 
<html>
 
<head>
    <meta charset="utf-8">
    <title>Taquillator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        form {
            margin: 20px;
        }
        select, input[type="submit"] {
            padding: 10px;
            font-size: 16px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
 
<body>
    <form action="" method="get">
    <select name="localidad">
        <option value="">Todas las localidades</option>
        <option value="Gijon" <?= $localidadSeleccionada == 'Gijon' ? 'selected' : ''; ?> >Gijon</option>
        <option value="Oviedo" <?= $localidadSeleccionada == 'Oviedo' ? 'selected' : ''; ?>>Oviedo</option>
        <option value="Aviles" <?= $localidadSeleccionada == 'Aviles' ? 'selected' : ''; ?>>Aviles</option>
    </select>
        <input type="submit" value="Buscar">
    </form>
 
</body>
 
</html>
 
 
 
<?php
if (isset($_GET['localidad'])) {

    ////////////////////////////////////////////
    // TODO 2: Obtener taquillas según filtro //
    ////////////////////////////////////////////
    $sql = "SELECT * FROM puntosderecogida";

    if($localidadSeleccionada !== '') {

        $sql .= " WHERE localidad = ?";
        $resultado = $conexion->prepare($sql);
        $resultado->execute([$localidadSeleccionada]);

    } else {

        $resultado = $conexion->query($sql);
    }
   
    if ($resultado->rowCount() > 0) {

        echo "<table><tr><th>Localidad</th><th>Dirección</th><th>Capacidad</th><th>Ocupadas</th></tr>";
       
        /////////////////////////////////////
        // TODO 3: Imprimir filas de tabla //
        /////////////////////////////////////
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            if($row['ocupadas'] !== $row['capacidad']){
                echo "<tr><td>" . htmlspecialchars($row["localidad"]) . "</td><td>" . htmlspecialchars($row["direccion"]) . "</td><td>" . htmlspecialchars($row["capacidad"]) . "</td><td>" . htmlspecialchars($row["ocupadas"]) . "</td></tr>";
            }
        }

        echo "</table>";

    } else {
        echo "No hay resultados";
    }
}

?>