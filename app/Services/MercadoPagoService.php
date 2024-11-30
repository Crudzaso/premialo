<?php

namespace App\Services;

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class MercadoPagoService
{
    public function __construct()
    {
        SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        echo "MercadoPago SDK cargado correctamente.";
    }

    public function createPaymentPreference($title, $quantity, $price, $callbackUrl)
    {
        // Crear una nueva preferencia de pago
        $preference = new \Preference();

        // Crear un nuevo ítem de pago
        $item = new \Item();
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
    }

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
