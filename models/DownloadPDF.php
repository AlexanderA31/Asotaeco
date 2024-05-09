<?php
require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';
require_once '../models/VentaModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use TCPDF;

class DownloadPDF extends Conectar
{

    public function getPDFHTML()
    {
        $ventas = new VentaModel();
        $clientData = $ventas->getClienteVenta($_POST['id_venta']);

        if (!empty($clientData)) {
            $clientData = $clientData[0];
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('ASOTAECO');
            $pdf->SetSubject('Sales Invoice');
            $pdf->SetKeywords('TCPDF, PDF, invoice, sales, Ecuador');
            $pdf->SetTitle('ASOTAECO VENTAS');
            $pdf->AddPage();
            // Establecer el JPEG quality
            $pdf->setJPEGQuality(75);
            // Obtener las dimensiones de la imagen
            $imagePath = '../public/images/icons/logo.png'; // Ruta de la imagen
            $imageSize = getImageSize($imagePath);
            $originalWidth = $imageSize[0]; // Ancho original de la imagen
            $originalHeight = $imageSize[1]; // Alto original de la imagen

            // Usar las dimensiones obtenidas en tu código TCPDF
            $pdf->Image(
                $imagePath, // Ruta de la imagen
                180, // X position (in millimeters)
                20, // Y position (in millimeters)
                25, // New width (in millimeters)
                (25 * $originalHeight) / $originalWidth, // Calculate proportional height based on new width
                '', // Image type (leave blank for auto-detection)
                'PNG', // Link (optional)
                '', // Use case for HTML mode (optional)
                false, // Preserve image proportions (optional)
                150, // DPI (optional)
                '', // Placeholder for internal image (optional)
                false, // Mask image (optional)
                false, // Transparent mask (optional)
                0, // Border mode (optional)
                false, // Interpolate (optional)
                false, // Fit to cell (optional)
                false // Allow HTML mode (optional)
            );


            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(130, 10, 'ASOTAECO', 0, 0, 'L');
            $invoiceNumber = $clientData['ncomprobante'];
            $invoiceDate = $clientData['fecha'];
            $pdf->Cell(60, 10, "N°: $invoiceNumber", 0, 0, 'R');
            $pdf->Cell(60, 10, date('d/m/Y', strtotime($invoiceDate)), 0, 0, 'R');
            $pdf->Ln(10);

            $clientName = $clientData['name_client'];
            $clientCI = $clientData['ci'];
            $clientAddress = $clientData['direccion'];
            $clientPhone = $clientData['telefono'];
            // Agregar información del cliente

            $pdf->SetTextColor(80, 80, 80);

            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(20, 10, "Cliente:", 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(140, 10, $clientName, 0, 1, 'L');
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(20, 10, "CI/RUC:", 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(140, 10, $clientCI, 0, 1, 'L');
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(20, 10, "Dirección:", 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(140, 10, $clientAddress, 0, 1, 'L');
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(20, 10, "Teléfono:", 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(140, 10, $clientPhone, 0, 1, 'L');
            $pdf->Ln(10);

            // Agregar tabla de productos
            $products = $ventas->getProductsVentaAdmin($_POST['id_venta']);
            $total = 0;
            $vatTotal = 0;
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetTextColor(80, 80, 80);
            $pdf->Cell(10, 10, "N.", 1, 0, 'C');
            $pdf->Cell(20, 10, "Cant.", 1, 0, 'C');
            $pdf->Cell(80, 10, "Descripción", 1, 0, 'C');
            $pdf->Cell(30, 10, "Precio Unitario", 1, 0, 'C');
            $pdf->Cell(30, 10, "Total", 1, 1, 'C');
            $pdf->SetFont('helvetica', '', 10);
            $con = 1;
            //   for ($i = 0; $i < 30; $i++) {
            foreach ($products as $product) {
                $quantity = $product['cantidad'];
                $description = $product['producto'] . " " . $product['talla'] . " " . $product['color'];
                $price = $product['precio'];
                $priceExclVat = $price / 1.15; // Dividir por 1.15 para eliminar el 15% de IVA
                $vat = $price - $priceExclVat; // El IVA es la diferencia entre el precio total y el precio sin IVA
                $total += $quantity * $priceExclVat; // Sumar al total el precio sin IVA
                $vatTotal += $quantity * $vat; // Sumar al total del IVA el IVA por cada producto
                $pdf->Cell(10, 10, $con, 1, 0, 'C');
                $pdf->Cell(20, 10, $quantity, 1, 0, 'C');
                $pdf->Cell(80, 10, $description, 1, 0, 'L');
                $pdf->Cell(30, 10, "$" . number_format($priceExclVat, 2), 1, 0, 'C');
                $pdf->Cell(30, 10, "$" . number_format($quantity * $priceExclVat, 2), 1, 1, 'C');
                $con++;
            }
            // }

            // Agregar totales
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->Cell(140, 10, "Subtotal:", 0, 0, 'R');
            $pdf->Cell(30, 10, "$" . number_format($total, 2), 1, 1, 'R');
            $pdf->Cell(140, 10, "IVA (15%):", 0, 0, 'R');
            $pdf->Cell(30, 10, "$" . number_format($vatTotal, 2), 1, 1, 'R');
            $pdf->Cell(140, 10, "Total:", 0, 0, 'R');
            $pdf->Cell(30, 10, "$" . number_format($total + $vatTotal, 2), 1, 1, 'R');

            $output = $pdf->Output('venta.pdf', 'S');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="factura_venta.pdf"');
            header('Content-Length: ' . strlen($output));
            echo $output;
            http_response_code(200);
            exit;
        } else {
            http_response_code(400);
            // Si no se encontraron datos del cliente, mostrar un mensaje de error
            echo "No se encontraron datos del cliente.";
        }
    }

    public function downloadStock($data)
    {

        // Crear instancia de TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Autor');
        $pdf->SetTitle('Tabla de productos');
        $pdf->SetSubject('Tabla de productos');
        $pdf->SetKeywords('TCPDF, PDF, tabla, productos');

        // Establecer márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Establecer auto página de ajuste
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Establecer el formato de página
        $pdf->AddPage();

        // Crear tabla HTML
        $html = '<table border="1">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Proveedor</th>';
        $html .= '<th>RUC</th>';
        $html .= '<th>Ocasión</th>';
        $html .= '<th>Nombre</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Teléfono</th>';
        $html .= '<th>Dirección</th>';
        $html .= '<th>Stock</th>';
        $html .= '<th>Stock Alert</th>';
        $html .= '<th>Precio</th>';
        $html .= '<th>Color</th>';
        $html .= '<th>Género</th>';
        $html .= '<th>Talla</th>';
        $html .= '<th>Imagen</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Recorrer los datos para crear las filas de la tabla
        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['prov_nombre'] . '</td>';
            $html .= '<td>' . $row['ruc'] . '</td>';
            $html .= '<td>' . $row['ocasion'] . '</td>';
            $html .= '<td>' . $row['nombre'] . '</td>';
            $html .= '<td>' . $row['email'] . '</td>';
            $html .= '<td>' . $row['telefono'] . '</td>';
            $html .= '<td>' . $row['direccion'] . '</td>';
            $html .= '<td>' . $row['stock'] . '</td>';
            $html .= '<td>' . $row['stock_alert'] . '</td>';
            $html .= '<td>' . $row['precio'] . '</td>';
            $html .= '<td>' . $row['color'] . '</td>';
            $html .= '<td>' . $row['genero'] . '</td>';
            $html .= '<td>' . $row['talla'] . '</td>';
            $html .= '<td><img src="' . $row['imagen'] . '" alt="Imagen del producto" style="max-width: 100px; max-height: 100px;"></td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Escribir contenido HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Cerrar documento y devolver el PDF
        $pdf->Output('tabla_productos.pdf', 'D');
    }
}
