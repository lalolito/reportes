<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'asistencias_jhon_harold');
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo']; // 'entrada' o 'salida'
    // Insertar en la base de datos
    $sql = "INSERT INTO inventario (fecha, codigo, nombre, cantidad, precio, tipo)
            VALUES ('$fecha', '$codigo', '$nombre', '$cantidad', '$precio', '$tipo')";
    if ($conn->query($sql) === TRUE) {
        // Redirigir a reporte.php después de guardar
        header('Location: reporte.php');
        exit;
    } else {
        echo 'Error al guardar los datos: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Color de fondo suave */
        }
        header {
            margin-bottom: 20px; /* Espaciado inferior */
        }
        .container {
            max-width: 600px; /* Ancho máximo del formulario */
            margin-top: 50px; /* Margen superior */
            padding: 20px; /* Espaciado interno */
            background-color: white; /* Fondo blanco para el formulario */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }
        h1 {
            color: #007bff; /* Color del título */
        }
        .btn {
            transition: background-color 0.3s, transform 0.2s; /* Transiciones suaves */
        }
        .btn:hover {
            background-color: #0056b3; /* Color de fondo al pasar el ratón */
            transform: scale(1.05); /* Efecto de aumento */
        }
        .form-label {
            font-weight: bold; /* Etiquetas en negrita */
        }
    </style>
</head>
<body>
<header>
    <a href="index.html" class="btn btn-primary">Volver</a>
</header>
    <div class="container">
        <h1 class="text-center">Registrar Movimiento de Inventario</h1>
        <form method="POST" class="shadow p-4 bg-light rounded">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" name="precio" id="precio" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
</html>