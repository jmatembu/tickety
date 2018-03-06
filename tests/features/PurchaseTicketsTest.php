<?php

use App\Concert;
use App\Billing\PaymentGateway;
use App\Billing\FakePaymentGateway;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseTicketsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    private function orderTickets($concert, $params)
    {
        $this->json('POST', "/concerts/{$concert->id}/orders", $params);
    }

    private function assertValidationError($field)
    {
        $this->assertResponseStatus(422);
        $this->assertArrayHasKey($field, $this->decodeResponseJson());
    }

    /** @test */
    public function customer_can_purchase_tickets_to_published_concert()
    {
    	// Arrange
        $concert = factory(Concert::class)->states('published')->create([
            'price' => 3250
        ]);
        
        // Purchase concert tickets
        $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertResponseStatus(201);

        // Make sure the customer was charged the correct amount
        $this->assertEquals(9750, $this->paymentGateway->totalCharges());
        // Make sure that an order exists for this concert
        $order = $concert->orders()->where('email', 'john@example.com')->first();
        $this->assertNotNull($order);
        // Make sure that the order has 3 tickets
        $this->assertEquals(3, $order->tickets()->count());
    }

    function cannot_purchase_tickets_to_unpublished_concerts()
    {
        $concert = factory(Concert::class)->states('unpublished')->create();
    
        $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertResponseStatus(404);
        $this->assertEquals(0, $concert->orders()->count());
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /** @test */
    function order_is_not_created_if_purchase_fails()
    {
        $this->disableExceptionHandling();
        
        $concert = factory(Concert::class)->states('published')->create([
            'price' => 3250
        ]);
        
        // Purchase concert tickets with invalid token
        $this->orderTickets($concert, [
            'email' => 'john@example.com',
            'quantity' => 3,
            'payment_token' => 'invalid-payment-token',
        ]);

        $this->assertResponseStatus(422);
        // Make sure that an order does not exist for this concert
        $order = $concert->orders()->where('email', 'john@example.com')->first();
        $this->assertNull($order);
    }

    /** @test */
    function email_is_required_to_purchace_tickets()
    {
        $concert = factory(Concert::class)->states('published')->create();

        // Purchase concert ticket without email
        $this->orderTickets($concert, [
            'quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError('email');
    }

    /** @test */
    function email_must_be_valid_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->states('published')->create();

        // Purchase concert ticket without an invalid email
        $this->orderTickets($concert, [
            'email' => 'asd_a.aads',
            'quantity' => 3,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError('email');
    }

    /** @ticket */
    function ticket_quantity_is_required_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->states('published')->create();

        // Purchase concert ticket without email
        $this->orderTickets($concert, [
            'email' => 'jane@example.com',
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError('quantity');
    }

    /** @test */
    function ticket_quantity_must_be_1_or_more_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->states('published')->create();

        // Purchase concert ticket 0 quantity
        $this->orderTickets($concert, [
            'email' => 'jane@example.com',
            'quantity' => 0,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError('quantity');
    }

    /** @test */
    function ticket_quantity_must_be_an_integer_to_purchase_tickets()
    {
        $concert = factory(Concert::class)->states('published')->create();

        // Purchase concert ticket non integer quantity
        $this->orderTickets($concert, [
            'email' => 'jane@example.com',
            'quantity' => 'one',
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $this->assertValidationError('quantity');
    }

    /** @test */
    function payment_token_is_required()
    {
        $concert = factory(Concert::class)->states('published')->create();

        // Purchase concert ticket without payment token
        $this->orderTickets($concert, [
            'email' => 'jane@example.com',
            'quantity' => 0,
        ]);

        $this->assertValidationError('payment_token');
    }
}
