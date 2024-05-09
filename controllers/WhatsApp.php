<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

class SendWhatsApp
{
    private $token = "GA240503202714";
    public function enviarMensajes($productos)
    {

        $client = new Client(['verify' => false]);
        $respuestas = array();

        foreach ($productos as $producto) {
            $messageBody = "Nombre del Producto: " . $producto['nombre'] . "\n";
            $messageBody .= "Cantidad Predeterminada: " . $producto['cant_pred'] . "\n";
            $messageBody .= "Proveedor: " . $producto['nombre_proveedor'] . "\n";
            $messageBody .= "Estado: " . ($producto['stock'] > 0 ? "Disponible" : "Agotado") . "\n";
            $phoneNumber = $producto['telefono'];

            $payload = array(
                "op" => "registermessage",
                "token_qr" => $this->token,
                "mensajes" => array(
                    array("numero" => $phoneNumber, "mensaje" => $messageBody)
                )
            );

            try {
                $response = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ],
                    'json' => $payload
                ]);

                $respuesta = array(
                    'codigo' => $response->getStatusCode(),
                    'mensaje' => $response->getBody()->getContents()
                );
                $respuestas[] = $respuesta;
            } catch (Exception $e) {
                // Handle errors
                $respuesta = array(
                    'codigo' => 500, // Indica un error interno del servidor
                    'mensaje' => "Error al enviar mensajes: " . $e->getMessage()
                );
                $respuestas[] = $respuesta;
            }
        }

        echo $respuestas;
    }

    public function enviarMensajesProveedor($telefono)
    {

        $client = new Client(['verify' => false]);
        $respuestas = array();

        $messageBody = "Espero que este mensaje lo/a encuentre bien. Me complace informarle que se ha enviado un correo electrónico a la dirección proporcionada con los detalles necesarios para solicitar un nuevo pedido de productos.
        Dentro del correo electrónico, encontrará toda la información relevante, incluyendo los productos requeridos, cantidades, especificaciones y cualquier otra instrucción importante para completar el pedido de manera satisfactoria.
        Por favor, revise su bandeja de entrada (y también la carpeta de spam o correo no deseado, si es necesario) para encontrar el correo electrónico enviado desde nuestra parte. Si tiene alguna pregunta o necesita asistencia adicional, no dude en ponerse en contacto con nosotros.
        Agradecemos mucho su atención y cooperación en este proceso. Esperamos continuar nuestra sólida asociación comercial y estamos ansiosos por recibir su respuesta.
        Gracias y saludos cordiales.";

        $telefono = substr($telefono, -9);
        $payload = array(
            "op" => "registermessage",
            "token_qr" => $this->token,
            "mensajes" => array(
                array("numero" => "593" . $telefono, "mensaje" => $messageBody)
            )
        );

        try {
            $response = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => $payload
            ]);

            $respuesta = array(
                'codigo' => $response->getStatusCode(),
                'mensaje' => $response->getBody()->getContents()
            );
            $respuestas[] = $respuesta;
        } catch (Exception $e) {
            // Handle errors
            $respuesta = array(
                'codigo' => 500, // Indica un error interno del servidor
                'mensaje' => "Error al enviar mensajes: " . $e->getMessage()
            );
            $respuestas[] = $respuesta;
        }

        echo $respuestas;
    }
}

// // Uso de la clase SendWhatsApp
// $sendWhatsApp = new SendWhatsApp();

// // Suponiendo que $productos contiene los datos de los productosa
// $productos = array(
//     array(
//         'nombre' => 'Producto 1',
//         'cant_pred' => 5,
//         'nombre_proveedor' => 'Proveedor 1',
//         'stock' => 3,
//         'telefono' => '593981319473' // Número de teléfono para enviar el mensaje
//     ),
//     array(
//         'nombre' => 'Producto 2',
//         'cant_pred' => 10,
//         'nombre_proveedor' => 'Proveedor 2',
//         'stock' => 0,
//         'telefono' => '593981319474' // Otro número de teléfono para enviar el mensaje
//     )
// );

// $response = $sendWhatsApp->enviarMensajes($productos);
