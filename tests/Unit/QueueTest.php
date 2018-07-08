<?php

namespace Tests\Feature;

use App\Entity\Currency;
use App\Jobs\SendRateChangedEmail;
use App\User;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{
    public function test_send_email_notification()
    {
        Queue::fake();

        $user = new User();
        $currency = new Currency();

        $user->fill([
            'id' => 1,
            'name' => 'Test1',
            'email' => 'test1@example.com'
        ]);

        $currency->fill([
            'id' => 1,
            'name' => 'Bitcoin',
            'rate' => 6999.12
        ]);

        $oldRate = 6888.43;

        $job = (new SendRateChangedEmail($user, $currency, $oldRate))->onQueue('notification');
        dispatch($job);

        Queue::assertPushed(SendRateChangedEmail::class, function ($job) use ($user, $currency, $oldRate) {
            return (
                $job->user->id === $user->id
                &&
                $job->currency->id === $currency->id
                &&
                $job->oldRate === $oldRate
            );
        });
        // Assert a job was pushed to a given queue...
        Queue::assertPushedOn('notification', SendRateChangedEmail::class);
    }
}