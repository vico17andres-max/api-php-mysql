<?php
include("conexion.php");

$mensaje = "";

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $materia = $conexion->real_escape_string($_POST['materia']);
    $nota = floatval($_POST['nota']);

    // Lógica para determinar si está aprobado o reprobado (nota mínima 51)
    $estado = ($nota >= 51) ? "Aprobado" : "Reprobado";

    $sql = "INSERT INTO estudiantes (nombre, materia, nota, estado) VALUES ('$nombre', '$materia', '$nota', '$estado')";
    
    if ($conexion->query($sql) === TRUE) {
        $mensaje = "¡Estudiante registrado con éxito!";
    } else {
        $mensaje = "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Estudiantes - Web III</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        button:hover { background-color: #218838; }
        .mensaje { text-align: center; color: green; font-weight: bold; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        .aprobado { color: green; font-weight: bold; }
        .reprobado { color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistema de Registro de Estudiantes</h2>
    
    <?php if(!empty($mensaje)) { echo "<div class='mensaje'>$mensaje</div>"; } ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nombre del Estudiante:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Materia:</label>
            <input type="text" name="materia" required>
        </div>
        <div class="form-group">
            <label>Nota Final (0 a 100):</label>
            <input type="number" step="0.01" name="nota" min="0" max="100" required>
        </div>
        <button type="submit">Registrar Estudiante</button>
    </form>

    <h3>Lista de Estudiantes Registrados</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Materia</th>
            <th>Nota</th>
            <th>Estado</th>
        </tr>
        <?php
        $resultado = $conexion->query("SELECT * FROM estudiantes ORDER BY id DESC");
        if ($resultado->num_rows > 0) {
            while($row = $resultado->fetch_assoc()) {
                $clase_estado = ($row['estado'] == 'Aprobado') ? 'aprobado' : 'reprobado';
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['materia']}</td>
                        <td>{$row['nota']}</td>
                        <td class='$clase_estado'>{$row['estado']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay registros todavía.</td></tr>";
        }
        $conexion->close();
        ?>
    </table>
</div>

</body>
</html>