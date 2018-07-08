<?php

namespace Tests\Feature;

use App\Entity\Currency;
use App\Mail\RateChanged;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_rate()
    {
        Mail::fake();
        $user1 = factory(User::class)->create([
            "is_admin" => false
        ]);
        $user2 = factory(User::class)->create([
            "is_admin" => false
        ]);
        $user3 = factory(User::class)->create([
            "is_admin" => false
        ]);
        $user = factory(User::class)->create([
            "is_admin" => true
        ]);
        $currency = factory(Currency::class)->create([
            "rate" => 1
        ]);

        $response = $this->actingAs($user)->json('PUT', '/api/currencies/1/rate', [
            "rate" => 2
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('currencies', [
            'id' => 1,
            'rate' => 2
        ]);

        Mail::assertSent(RateChanged::class, 3);
    }
}