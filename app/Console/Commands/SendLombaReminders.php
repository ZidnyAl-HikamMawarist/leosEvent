<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use App\Models\Lomba;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\LombaReminderMail;

class SendLombaReminders extends Command
{
    protected $signature = 'lomba:send-reminders';
    protected $description = 'Send automated email reminders 5-10 minutes before lomba starts';

    public function handle()
    {
        $this->info('Checking for upcoming lombas...');

        // Get lombas starting in 5-30 minutes (buffered to ensure we don't miss any if cron runs every minute)
        $now = Carbon::now('Asia/Jakarta');
        $startTime = $now->copy()->addMinutes(5);
        $endTime = $now->copy()->addMinutes(30);

        $upcomingLombas = Lomba::whereDate('tanggal_pelaksanaan', $now->toDateString())
            ->whereNotNull('event_start')
            ->get();

        foreach ($upcomingLombas as $lomba) {
            $lombaStart = Carbon::parse($lomba->tanggal_pelaksanaan . ' ' . $lomba->event_start, 'Asia/Jakarta');

            if ($lombaStart->between($startTime, $endTime)) {
                $pendaftarans = Pendaftaran::where('lomba_id', $lomba->id)
                    ->where('reminder_sent', false)
                    ->get();

                if ($pendaftarans->count() > 0) {
                    $this->info("Sending reminders for: {$lomba->nama_lomba} ({$pendaftarans->count()} pendaftar)");

                    foreach ($pendaftarans as $pendaftaran) {
                        try {
                            Mail::to($pendaftaran->email)->send(new LombaReminderMail($pendaftaran, $lomba));
                            $pendaftaran->update(['reminder_sent' => true]);
                            $this->line("Sent to: {$pendaftaran->email}");
                        } catch (\Exception $e) {
                            $this->error("Failed to send to {$pendaftaran->email}: " . $e->getMessage());
                        }
                    }
                }
            }
        }

        $this->info('Reminder check completed.');
    }
}
