<?php
include("db_ecommerce.php");
$con = mysqli_connect($host, $user, $pass, $db);
$query = "SELECT v.id AS idVenta, v.idCli, v.idPago, v.fecha, dv.idProd, dv.cantidad, dv.precio, dv.subTotal
          FROM ventas v
          INNER JOIN detalleventas dv ON v.id = dv.idVenta";
$result = mysqli_query($con, $query);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . mysqli_error($con));
}

// Aquí puedes procesar los resultados, por ejemplo, imprimir el informe
echo "<div style='margin: 0 auto; width: 50%; text-align:center;'>";
echo "<h2>Reporte de Ventas</h2>";
echo "<table border='1'>
        <tr>
            <th>ID Venta</th>
            <th>ID Cliente</th>
            <th>ID Pago</th>
            <th>Fecha</th>
            <th>ID Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    // Formatear el precio con símbolo de dólar
    $precioConDolar = "$" . number_format($row['precio'], 2);
    $subtotalConDolar = "$" . number_format($row['subTotal'], 2);

    echo "<tr>
            <td>{$row['idVenta']}</td>
            <td>{$row['idCli']}</td>
            <td>{$row['idPago']}</td>
            <td>{$row['fecha']}</td>
            <td>{$row['idProd']}</td>
            <td>{$row['cantidad']}</td>
            <td>{$precioConDolar}</td>
            <td>{$subtotalConDolar}</td>
          </tr>";
}


echo "</table>";
echo "</div>";

// Cerrar la conexión
mysqli_close($con);

?>

