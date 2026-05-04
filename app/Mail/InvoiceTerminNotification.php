<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceTerminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Project $project;
    public int $terminPercentage;
    public float $terminAmount;

    public function __construct(Project $project, int $terminPercentage)
    {
        $this->project = $project;
        $this->terminPercentage = $terminPercentage;
        $this->terminAmount = $project->contract_value
            ? ($project->contract_value * $terminPercentage) / 100
            : 0;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Notifikasi Termin Invoice {$this->terminPercentage}% - Proyek {$this->project->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-termin-notification',
            with: [
                'project' => $this->project,
                'terminPercentage' => $this->terminPercentage,
                'terminAmount' => $this->terminAmount,
            ],
        );
    }
}
