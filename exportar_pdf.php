<?php
require('fpdf/fpdf.php');

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'asistencias_jhon_harold');
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Consulta para obtener los datos agrupados por código y tipo
$sql = "SELECT codigo, nombre, tipo, SUM(cantidad) AS total_cantidad, SUM(precio * cantidad) AS total_valor 
        FROM inventario 
        GROUP BY codigo, tipo 
        ORDER BY codigo, tipo";
$result = $conn->query($sql);

// Crea una instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título
$pdf->Cell(0, 10, 'Reporte de Inventario (Entradas y Salidas por Codigo)', 0, 1, 'C');
$pdf->Ln(10);

// Encabezado de tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Codigo', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tipo', 1, 0, 'C');
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
$pdf->Cell(40, 10, 'Valor Total', 1, 1, 'C');

// Variables para totales por código
$current_code = '';
$total_entradas = 0;
$total_salidas = 0;
$valor_entradas = 0;
$valor_salidas = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Si el código cambia, imprime los totales y resetea las variables
        if ($current_code != $row['codigo']) {
            if ($current_code != '') {
                // Imprime los totales de entradas y salidas
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(120, 10, 'Totales para Codigo: ' . $current_code, 1, 0, 'C');
                $pdf->Cell(30, 10, 'Entradas: ' . $total_entradas, 1, 0, 'C');
                $pdf->Cell(40, 10, 'Salidas: ' . $total_salidas, 1, 1, 'C');
                
                $pdf->Cell(120, 10, '', 0, 0); // Espaciado
                $pdf->Cell(30, 10, 'Valor Entradas: $' . number_format($valor_entradas, 2), 1, 0, 'C');
                $pdf->Cell(40, 10, 'Valor Salidas: $' . number_format($valor_salidas, 2), 1, 1, 'C');
                $pdf->Ln(5); // Espaciado entre códigos
            }
            // Reinicia variables
            $current_code = $row['codigo'];
            $total_entradas = 0;
            $total_salidas = 0;
            $valor_entradas = 0;
            $valor_salidas = 0;
        }

        // Suma las cantidades y valores según el tipo (entrada/salida)
        if ($row['tipo'] === 'entrada') {
            $total_entradas += $row['total_cantidad'];
            $valor_entradas += $row['total_valor'];
        } elseif ($row['tipo'] === 'salida') {
            $total_salidas += $row['total_cantidad'];
            $valor_salidas += $row['total_valor'];
        }

        // Agregar fila a la tabla
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 10, $row['codigo'], 1, 0, 'C');
        $pdf->Cell(50, 10, $row['nombre'], 1, 0, 'C');
        $pdf->Cell(30, 10, ucfirst($row['tipo']), 1, 0, 'C'); // Capitaliza el tipo
        $pdf->Cell(30, 10, $row['total_cantidad'], 1, 0, 'C');
        $pdf->Cell(40, 10, '$' . number_format($row['total_valor'], 2), 1, 1, 'C');
    }

    // Imprime los totales para el último código
    if ($current_code != '') {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(120, 10, 'Totales para Codigo: ' . $current_code, 1, 0, 'C');
        $pdf->Cell(30, 10, 'Entradas: ' . $total_entradas, 1, 0, 'C');
        $pdf->Cell(40, 10, 'Salidas: ' . $total_salidas, 1, 1, 'C');

        $pdf->Cell(120, 10, '', 0, 0); // Espaciado
        $pdf->Cell(30, 10, 'Valor Entradas: $' . number_format($valor_entradas, 2), 1, 0, 'C');
        $pdf->Cell(40, 10, 'Valor Salidas: $' . number_format($valor_salidas, 2), 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'No hay datos disponibles.', 1, 1, 'C');
}

// Salida del PDF
$pdf->Output();
?>
