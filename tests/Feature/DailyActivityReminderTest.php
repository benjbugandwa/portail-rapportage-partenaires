<?php

namespace Tests\Feature;

use App\Mail\DailyActivityReminderMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DailyActivityReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_daily_activity_reminder_command_sends_emails_to_active_users(): void
    {
        Mail::fake();

        $activeUser = User::factory()->create([
            'nom' => 'Active User',
            'is_active' => true,
            'email' => 'active@example.com',
        ]);

        $inactiveUser = User::factory()->create([
            'nom' => 'Inactive User',
            'is_active' => false,
            'email' => 'inactive@example.com',
        ]);

        $this->artisan('app:send-daily-activity-reminder')
            ->assertExitCode(0);

        Mail::assertSent(DailyActivityReminderMail::class, function ($mail) use ($activeUser) {
            return $mail->hasTo($activeUser->email);
        });

        Mail::assertNotSent(DailyActivityReminderMail::class, function ($mail) use ($inactiveUser) {
            return $mail->hasTo($inactiveUser->email);
        });
    }
}
