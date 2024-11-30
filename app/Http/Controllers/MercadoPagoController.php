<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MercadoPagoService;

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
        return view('mercado_pago.payment');
    }

    // Crear la preferencia de pago y redirigir a la URL de pago
    public function createPayment(Request $request)
    {
        $title = $request->input('title');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $callbackUrl = route('mercado_pago.callback');

        // Crear preferencia de pago
        $paymentUrl = $this->mercadoPagoService->createPaymentPreference($title, $quantity, $price, $callbackUrl);

        // Redirigir al usuario a la URL de pago
        return redirect()->to($paymentUrl);
    }

    // Recibir el callback de MercadoPago
    public function paymentCallback(Request $request)
    {
        $statusMessage = $this->mercadoPagoService->validatePaymentStatus($request->all());

        // Mostrar el estado del pago en la vista
        return view('mercado_pago.callback', ['statusMessage' => $statusMessage, 'queryParams' => $request->all()]);
    }
}
