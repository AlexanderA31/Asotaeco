<?php

require_once '../vendor/autoload.php';
require_once '../config/Conectar.php';
require_once '../models/PDFModel.php';
require_once '../models/CorreosModel.php';

use GuzzleHttp\Client;

class SendWhatsAppModel
{
    private  $token = "PA240505223813";
    public function enviarMensajesProveedor($telefono)
    {
        $client = new Client(['verify' => false]);
        $respuestas = array();
        $messageBody = "¡Hola! Te saludamos de parte de *ASOTAECO*. Quería informarte que hemos enviado un correo con los detalles para tu nuevo pedido de productos. Revisa tu bandeja de entrada (y spam) para encontrarlo. Si tienes dudas, contáctanos. ¡Gracias por tu colaboración! Esperamos seguir trabajando juntos. ¡Saludos!";
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
            $respuesta = array(
                'codigo' => 500, // Indica un error interno del servidor
                'mensaje' => "Error al enviar mensajes: " . $e->getMessage()
            );
            $respuestas[] = $respuesta;
        }

        return $respuestas;
    }
    public function enviarMensajes($productos)
    {



        try {

            $client = new Client(['verify' => false]);

            foreach ($productos as $producto) {
                $telefono = $producto['telefono'];
                $url =  Conectar::ruta() . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
                $imageData = file_get_contents($url);
                $base64Image = base64_encode($imageData);

                $payload = array(
                    "op" => "registermessage",
                    "token_qr" => $this->token,
                    "mensajes" => array(
                        array(
                            "numero" => $telefono, "mensaje" => "Hola,👋 *",
                        ),
                        array("numero" => $telefono, "imagenbase64" => $base64Image)
                    )
                );
                $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ], 'json' =>  $payload
                ]);
                $response = [
                    "http_code" => $res->getStatusCode(),
                    "sms" => $res->getBody()
                ];
                echo $response;
            }
            return $res->getBody();
        } catch (Exception $e) {
            http_response_code(400);
            $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
        }
    }
}



// class SendWhatsApp
// {
//     public function getToken()
//     {
//         return "PA240410210517";
//     }

//     public function enviarMensajes($productos)
// {
//     try {
//         $client = new Client(['verify' => false]);
//         $responses = [];

//         foreach ($productos as $producto) {
//             // Asegurarse de que los datos del producto sean correctos
//             var_dump($producto);

//             $telefono = $producto['telefono'];
//             $url =  Conectar::ruta() . str_replace("//", "/", str_replace("..", "", $producto['imagen']));
//             $imageData = file_get_contents($url);
//             $base64Image = base64_encode($imageData);

//             $payload = array(
//                 "op" => "registermessage",
//                 "token_qr" => $this->getToken(),
//                 "mensajes" => array(
//                     array(
//                         "numero" => $telefono,
//                         "mensaje" => "Hola,👋 *" . $producto['nombre_proveedor'] . "*\n" .
//                             " este es el sistema de alertas automaticas de *ASOTAECO* para hacer un pedido de: \n" .
//                             "*Producto:* " . $producto['nombre_producto'] . "\n" .
//                             "*Descripción:* " . $producto['descripcion_producto'] . "\n" .
//                             "*Tipo:* " . $producto['tipo'] . "\n" .
//                             "*Color:* " . $producto['color'] . "\n" .
//                             "*Talla:* " . $producto['talla'] . "\n" .
//                             "*Cantidad que se desea adquirir:* " . $producto['cant_pred'] . " Unidades\n" .
//                             "Para solicitar este producto, por favor comuníquese a este número lo mas pronto posible.\nAdjunto imagen de la prenda requerida👇"
//                     ),
//                     array("numero" => $telefono, "imagenbase64" => $base64Image)
//                 )
//             );

//             // Imprime el payload para verificar que sea correcto
//             var_dump($payload);

//             $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
//                 'headers' => [
//                     'Content-Type' => 'application/json',
//                     'Accept' => 'application/json'
//                 ],
//                 'json' =>  $payload
//             ]);

//             $response = [
//                 "http_code" => $res->getStatusCode(),
//                 "sms" => $res->getBody()
//             ];

//             // Añade la respuesta a un array para un manejo posterior
//             $responses[] = $response;
//         }
//         // Devuelve todas las respuestas como JSON
//         return json_encode($responses);
//     } catch (Exception $e) {
//         // Captura y maneja cualquier error que pueda ocurrir
//         http_response_code(400);
//         $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
//         $errorResponse = [
//             "http_code" => http_response_code(),
//             "error" => $errorMsg
//         ];
//         $errorJson = json_encode($errorResponse);
//         return $errorJson;
//     }
// }

//     public function enviarMensaje()
//     {
//         try {

//             $client = new Client(['verify' => false]);

//             $telefono = "593985726434";
//             $payload = array(
//                 "op" => "registermessage",
//                 "token_qr" => $this->getToken(),
//                 "mensajes" => array(
//                     array(
//                         "numero" => $telefono, "mensaje" => "Hola,👋 Adjunto imagen de la prenda requerida👇"
//                     )
//                     //array("numero" => $telefono, "imagenbase64" => $base64Image)
//                 )
//             );
//             $res = $client->request('POST', 'https://script.google.com/macros/s/AKfycbyoBhxuklU5D3LTguTcYAS85klwFINHxxd-FroauC4CmFVvS0ua/exec', [
//                 'headers' => [
//                     'Content-Type' => 'application/json',
//                     'Accept' => 'application/json'
//                 ], 'json' =>  $payload
//             ]);
            
//             return json_encode($res);
//         } catch (Exception $e) {
//             http_response_code(400);
//             $errorMsg = "Error al enviar mensajes: " . $e->getMessage();
//             $errorResponse = [
//                 "http_code" => http_response_code(),
//                 "error" => $errorMsg
//             ];
//             $errorJson = json_encode($errorResponse);
//             return $errorJson;
//         }
//     }
// }
