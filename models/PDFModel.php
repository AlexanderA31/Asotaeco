<?php
require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';
require_once '../models/CorreosModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use TCPDF;

class PDFModel extends Conectar
{
    public function generarEstiloCSS()
    {
        $css = '
            <style>
                .container {
                    text-align: center;
                    margin-top: 20px;
                }
                .logo img {
                    max-height: 150px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    border: 1px solid #000; /* Ejemplo de estilo de borde para la tabla */
                }
                th, td {
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                img.producto {
                    max-width: 150px;
                    max-height: 150px;
                }
            </style>';
        return $css;
    }

    public function getVentaUser()
    {
        try {
            $id = $_GET["id"];
            $conexion = parent::Conexion();
            $sql = "SELECT 
                dv.id, 
                dv.id_venta, 
                dv.cantidad, 
                dv.precio_unitario, 
                p.nombre AS nombre_producto,
                ip.url_imagen AS imagen,
                i.id_color,
                i.id_talla,
                c.color,
                t.talla,
                v.fecha,
                v.total,
                v.envio,
                r.nombre as receptor_nombre,
                r.telefono as receptor_telefono,
                r.email as receptor_email,
                r.direccion as receptor_direccion,
                r.ci as receptor_ci
                
            FROM 
                detalles_venta dv
            JOIN 
                inventario i ON dv.id_variante_producto = i.id
            JOIN 
                ventas v ON dv.id_venta = v.id
            JOIN 
                colores c ON i.id_color = c.id
                JOIN 
                recibe r ON v.id_recibe = r.id
            JOIN 
                tallas t ON i.id_talla = t.id
            JOIN 
                productos p ON i.id_producto = p.id
            LEFT JOIN 
                imagenes_producto ip ON p.id = ip.id_producto AND ip.orden = 1 WHERE dv.id_venta=?;
            ";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $html = '<div>';
            $html .= '<p>Fecha: ' . $ventas[0]['fecha'] . '</p>';
            $html .= '<p>Número de factura: ' . $ventas[0]['id_venta'] . '</p>';
            $html .= '<p>Cliente: ' . $ventas[0]['receptor_nombre'] . '</p>';
            $html .= '<p>Teléfono: ' . $ventas[0]['receptor_telefono'] . '</p>';
            $html .= '<p>Email: ' . $ventas[0]['receptor_email'] . '</p>';
            $html .= '<p>Dirección: ' . $ventas[0]['receptor_direccion'] . '</p>';
            $html .= '</div>';
            $html .= '<table>';
            $html .= '<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th></tr>';
            foreach ($ventas as $venta) {
                $html .= '<tr>';
                $html .= '<td>' . $venta['nombre_producto'] . '</td>';
                $html .= '<td>' . $venta['cantidad'] . '</td>';
                $html .= '<td>$' . $venta['precio_unitario'] . '</td>';
                $html .= '</tr>';
            }

            $html .= '</table>';
            $html .= '<p>Subtotal: $' . $ventas[0]['total'] . '</p>';
            $html .= '<p>Envío: $' . $ventas[0]['envio'] . '</p>';
            $html .= '<p>Total: $' . ($ventas[0]['total'] + $ventas[0]['envio']) . '</p>';
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="factura_venta.pdf"');
            header('Content-Length: ' . strlen($output));
            echo $output;
            exit;
        } catch (Exception $e) {
            http_response_code(400);
            return $e;
        }
    }



    public function alertaPDF($data, $email)
    {


        // Nombre de la empresa y tagline (encabezado)
        $empresa = 'ASOTAECO';
        $tagline = 'Pedido de productos';

        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Creación del objeto Dompdf
        $dompdf = new Dompdf($options);

        // Configuración del documento
        $dompdf->setPaper('A4', 'landscape');

        $html = "<div style='text-align:center; margin-bottom:20px;'>";
        $html .= "<h1 style='font-size:24px; margin-bottom:10px;'>$empresa</h1>";
        $html .= "<p style='font-size:16px; margin:0;'>$tagline</p>";
        $html .= "</div>";

        $html .= "<table style='width:100%; border-collapse: collapse;'>";
        $html .= "<tr>";
        $html .= "<th style='background-color:#f2f2f2; font-weight:bold; padding:10px; border: 1px solid #ddd;'>N.</th>";
        //$html .= "<th style='background-color:#f2f2f2; font-weight:bold; padding:10px; border: 1px solid #ddd;'>Imagen</th>";
        $html .= "<th style='background-color:#f2f2f2; font-weight:bold; padding:10px; border: 1px solid #ddd;'>Nombre</th>";
        $html .= "<th style='background-color:#f2f2f2; font-weight:bold; padding:10px; border: 1px solid #ddd;'>Descripción</th>";
        $html .= "<th style='background-color:#f2f2f2; font-weight:bold; padding:10px; border: 1px solid #ddd;'>Talla</th>";
        $html .= "<th style='background-color:#f2f2f2; font-weight:bold; padding:10px; border: 1px solid #ddd;'>Color</th>";
        $html .= "<th style='background-color:#f2f2f2; font-weight:bold; padding:10px; border: 1px solid #ddd;'>Cantidad</th>";
        $html .= "</tr>";

        $con = 1;
        foreach ($data as $row) {
            $html .= "<tr>";
            $html .= "<td style='padding:10px; text-align:center; border: 1px solid #ddd;'>{$con}</td>";
            //$imagen_src = "https://asotaeco.com/" . substr($row['imagen'], 6); 
           // $html .= "<td style='padding:10px; text-align:center; border: 1px solid #ddd;'><img src='{$imagen_src}' width='100'></td>";
            $html .= "<td style='padding:10px; border: 1px solid #ddd;'>{$row['nombre_producto']}</td>";
            $html .= "<td style='padding:10px; border: 1px solid #ddd;'>{$row['descripcion_producto']}</td>";
            $html .= "<td style='padding:10px; text-align:center; border: 1px solid #ddd;'>{$row['talla']}</td>";
            $html .= "<td style='padding:10px; text-align:center; border: 1px solid #ddd;'>{$row['color']}</td>";
            $html .= "<td style='padding:10px; text-align:center; border: 1px solid #ddd;'>{$row['cant_pred']}</td>";
            $html .= "</tr>";
            $con++;
        }

        $html .= "</table>";

        // Cargar contenido HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF
        $pdfContent = $dompdf->output();

        // Salida del PDF
  /*      $file_path = 'alerta_pedido.pdf';
        file_put_contents($file_path, $pdfContent);

        // Descargar el PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="' . $file_path . '"');
*/

        // Envío del correo electrónico
        $correosModel = new CorreosModel();
        $mensajeHTML = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Alerta de Pedido</title>
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #e7e7e7; color: #000000;">
            <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="https://asotaeco.com/public/images/icons/logo.png" alt="Logo" style="max-width: 100%; height: 90px;">
                </div>
                <h1 style="font-size: 24px; margin-bottom: 20px; text-align: center;">Alerta de Pedido</h1>
                <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Estimado/a Proveedor/a,</p>
                <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Adjunto a este correo electrónico encontrarás una alerta de pedido con los productos de ropa que se deben confeccionar según nuestras especificaciones.</p>
                <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Te agradeceríamos mucho que confirmaras la fecha de entrega estimada para este pedido. Esto nos permitirá organizar nuestra producción y garantizar una entrega oportuna.</p>
                <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Quedamos a tu disposición para cualquier pregunta o aclaración adicional que necesites.</p>
                <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px; text-align: center;">Atentamente,<br>Asotaeco</p>
            </div>
        </body>
        </html>
        ';
        $result = $correosModel->enviarCorreoPDF($email, "Alerta de Pedido ASOTAECO", $mensajeHTML, $pdfContent);

        if ($result === "El correo se ha enviado correctamente.") {
            echo $result;
        } else {
            echo $result;
        }
    }
   

    public function ventaPDF($id, $email)
    {
        $ventas = new VentaModel();
        $clientData = $ventas->getClienteVenta($id);

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
            $invoiceNumber = preg_replace('/\D/', '', $clientData['fecha']);
            $invoiceDate = $clientData['fecha'];
            $pdf->Cell(60, 10, "N°: $invoiceNumber", 0, 0, 'R');
            $pdf->Cell(60, 10, date('d/m/Y', strtotime($invoiceDate)), 0, 0, 'R');
            $pdf->Ln(10);

            $clientName = $clientData['name_client'];
            $clientCI = $clientData['ci'];
            $clientAddress = $clientData['provincia'] . " " . $clientData['canton'] . " " . $clientData['direccion'] . " Referencia " . $clientData['referencia'];
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
            $products = $ventas->getProductsVentaAdmin($id);
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
            $pdfContent = $pdf->Output('factura_venta.pdf', 'S');
            $correosModel = new CorreosModel();
            $mensajeHTML = '
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Envío</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #e7e7e7; color: #000000;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="https://asotaeco.com/public/images/icons/logo.png" alt="Logo" style="max-width: 100%; height: 90px;">
        </div>
        <h1 style="font-size: 24px; margin-bottom: 20px; text-align: center;">Confirmación de Envío</h1>
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Estimado/a Cliente/a,</p>
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Nos complace informarte que tu pedido ha sido procesado. Adjunto a este correo electrónico encontrarás los detalles de tu compra.</p>
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Por favor, revisa el contenido del paquete cuando llegue y asegúrate de que todo esté en orden. Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">Esperamos que disfrutes de tus productos y que tengas una excelente experiencia de compra con nosotros.</p>
        <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px; text-align: center;">Atentamente,<br>Equipo de ASOTAECO</p>
        <div style="text-align: center;">
            <a href="https://www.facebook.com/tuempresa" style="text-decoration: none; margin-right: 10px;"><img src="https://cdn.tools.unlayer.com/social/icons/circle/facebook.png" alt="Facebook" style="max-width: 32px;"></a>
            <a href="mailto:info@tuempresa.com" style="text-decoration: none;"><img src="https://cdn.tools.unlayer.com/social/icons/circle/email.png" alt="Email" style="max-width: 32px;"></a>
        </div>
    </div>
</body>
</html>
        ';

            $result = $correosModel->enviarCorreoPDF($email, "Confirmación de Venta ASOTAECO", $mensajeHTML, $pdfContent);
            if ($result === "El correo se ha enviado correctamente.") {
                echo $result;
            } else {
                echo $result;
            }

            exit;
        } else {
            http_response_code(400);
            // Si no se encontraron datos del cliente, mostrar un mensaje de error
            echo "No se encontraron datos del cliente.";
        }
    }
}
