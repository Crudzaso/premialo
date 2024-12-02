<?php

namespace App\Services;

require_once __DIR__ . '/../../vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Item;


class MercadoPagoService
{
    public function __construct()
    {
        // Configura el token de acceso
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        echo "MercadoPago SDK cargado correctamente.";
    }

    // Método para crear la preferencia de pago
    public function createPaymentPreference($title, $quantity, $price, $callbackUrl)
    {
        try {
            // Crear una nueva preferencia de pago
            $preference = new PreferenceClient();

            // Crear un nuevo ítem de pago
            $item = new ItemClient();   
            $item->title = $title;
            $item->quantity = $quantity;
            $item->unit_price = $price;

            // Asignar el ítem a la preferencia
            $preference->items = [$item];

            // Configurar las URLs de retorno
            $preference->back_urls = [
                'success' => $callbackUrl . '/success',
                'failure' => $callbackUrl . '/failure',
                'pending' => $callbackUrl . '/pending',
            ];

            // Configurar el retorno automático de pago aprobado
            $preference->auto_return = 'approved';

            // Guardar la preferencia en Mercado Pago
            $preference->save();

            // Retornar el punto de inicio de la preferencia (URL de pago)
            return $preference->init_point;
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            // Captura el error y muestra el mensaje de la API
            echo "Error de API: " . $e->getMessage();
            var_dump($e->getApiResponse()->getContent()); // Muestra los detalles del error
            return null;
        } catch (\Exception $e) {
            // Captura cualquier otro tipo de error
            echo "Error general: " . $e->getMessage();
            return null;
        }
    }


    // Método para validar el estado del pago
    public function validatePaymentStatus(array $queryParams)
    {
        if (isset($queryParams['status'])) {
            switch ($queryParams['status']) {
                case 'approved':
                    return "Pago aprobado con éxito.";
                case 'pending':
                    return "El pago está pendiente.";
                case 'failure':
                    return "El pago falló o fue cancelado.";
                default:
                    return "Estado de pago desconocido.";
            }
        }

        return "Estado de pago no disponible.";
    }
}
