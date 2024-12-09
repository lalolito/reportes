# Reporte de Inventario en PDF

Este proyecto permite generar un reporte en formato PDF de las entradas y salidas de inventario, agrupadas por código y con totales resaltados para cada código. El reporte incluye información sobre las cantidades y valores de entradas y salidas, y está diseñado para destacar los totales de forma clara.

## Características

- Agrupa los datos de inventario por código y tipo (entrada/salida).
- Genera totales de cantidades y valores para cada código.
- Resalta los totales con una fuente más grande y un fondo destacado.
- Organiza los datos en una tabla con columnas claras (código, nombre, tipo, cantidad, valor total).

## Tecnologías utilizadas

- **PHP**: Para la lógica del servidor.
- **FPDF**: Librería para generar el archivo PDF.
- **MySQL**: Base de datos para almacenar los datos del inventario.

## Requisitos previos

Antes de comenzar, asegúrate de tener lo siguiente instalado:

1. **XAMPP** (u otro servidor local con PHP y MySQL).
2. Librería **FPDF**: Descárgala desde [fpdf.org](http://www.fpdf.org/) y colócala en el directorio de tu proyecto (dentro de una carpeta `fpdf`).

## Instalación

1. Clona este repositorio o copia los archivos a tu servidor local.
2. Importa el archivo `asistencias.sql` (si está disponible) a tu base de datos MySQL. Asegúrate de que la base de datos se llama `asistencias`.
3. Verifica que el archivo de configuración de la base de datos en el código tiene las credenciales correctas:
   ```php
   $conn = new mysqli('localhost', 'root', '', 'asistencias_jhon_harold');
