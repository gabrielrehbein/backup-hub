<?php

namespace App\Modules\Notifications\Mail;

use App\Modules\Backups\Models\BackupRisk;
use App\Modules\Risks\Enums\RiskTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackupRiskMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private BackupRisk $backupRisk,
    ){}


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Risco de Backup',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'backup-risk-mail',
            with: [
                'backupRisk' => $this->backupRisk,
            ],
        );
    }
}
