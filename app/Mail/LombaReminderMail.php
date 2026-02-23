<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftaran;
use App\Models\Lomba;

class LombaReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;
    public $lomba;

    public function __construct(Pendaftaran $pendaftaran, Lomba $lomba)
    {
        $this->pendaftaran = $pendaftaran;
        $this->lomba = $lomba;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder Lomba: ' . $this->lomba->nama_lomba . ' Segera Dimulai!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lomba_reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
