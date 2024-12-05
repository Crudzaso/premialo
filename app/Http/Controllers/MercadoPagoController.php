<?php

namespace App\Http\Controllers;

use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use App\Events\ErrorOccurred;
use Illuminate\Support\Facades\Log;

class MercadoPagoController extends Controller
{
    protected $mercadoPagoService;

    public function __construct(MercadoPagoService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }

    // Mostrar el formulario de pago
    public function showPaymentForm()
    {
        return view('mercadopago.payment');
    }

    // Crear la preferencia de pago
    public function createPayment(Request $request)
    {
        $items = [
            [
                "id" => "1234567890",
                "title" => "Producto 1", 
                "currency_id" => "COP",  // Moneda de Colombia
                "quantity" => 1,
                "unit_price" => 100.00  // Precio en COP
            ]
        ];

        $payer = [
            "name" => "TESTUSER800659108",  // Nombre del comprador
            "surname" => "TESTUSER",        // Apellido del comprador
            "email" => "testuser800659108@test.com", // Correo electrónico ficticio
            "identification" => [
                "type" => "CC",  // Tipo de documento para Colombia es CC (Cédula de Ciudadanía)
                "number" => "123456789"  // Número de cédula ficticio
            ]
        ];

        $preference = $this->mercadoPagoService->createPaymentPreference($items, $payer);

        if ($preference) {
            return redirect($preference->init_point); // Redirige al sandbox de MercadoPago.
        } else {
            Log::error('Mercado Pago error:', ['message' => 'No se pudo crear la preferencia de pago.']);
            event(new ErrorOccurred('Error al pagar con Mercado Pago', 'No se pudo crear la preferencia.'));
            return redirect()->route('mercadopago.payment')->with('error', 'Error al crear la preferencia de pago.');
        }
    }

    // Página de éxito del pago
    public function success()
    {
        return view('mercadopago.success');
    }

    // Página de fallo en el pago
    public function failure()
    {
        return view('mercadopago.failure');
    }
}
