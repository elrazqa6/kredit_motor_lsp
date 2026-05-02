<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestMidtransWebhook extends Command
{
    protected $signature = 'midtrans:test-webhook {order_id} {status}';
    protected $description = 'Test Midtrans webhook locally';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        $status = $this->argument('status');
        
        $payload = [
            'order_id' => $orderId,
            'transaction_status' => $status,
            'fraud_status' => 'accept',
            'status_code' => '200',
            'gross_amount' => 10000,
            'payment_type' => 'credit_card'
        ];
        
        $response = Http::post('http://localhost:8000/midtrans/notification', $payload);
        
        $this->info('Webhook test sent!');
        $this->info('Response: ' . $response->body());
    }
}