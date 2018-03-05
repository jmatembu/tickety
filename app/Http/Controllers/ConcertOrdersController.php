<?php

namespace App\Http\Controllers;

use App\Concert;
use Illuminate\Http\Request;
use App\Billing\PaymentGateway;
use App\Billing\PaymentFailedException;

class ConcertOrdersController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId)
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'quantity' => 'required|integer|min:1',
            'payment_token' => 'required'
        ]);

        try {

            $concert = Concert::find($concertId);
            $this->paymentGateway->charge(request('quantity') * $concert->price, request('payment_token'));
            $order = $concert->orderTickets(request('email'), request('quantity'));

            return response()->json([], 201);

        } catch (PaymentFailedException $e) {
            return response()->json([], 422);
        }
        
        
    }
}
