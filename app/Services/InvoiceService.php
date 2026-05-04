<?php

namespace App\Services;

use App\Mail\InvoiceTerminNotification;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class InvoiceService
{
    public function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');
        
        $lastInvoice = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->first();

        $sequence = $lastInvoice ? (int)substr($lastInvoice->invoice_number, -4) + 1 : 1;
        
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    public function notifyInvoiceRequired(Project $project, int $terminPercentage): void
    {
        // Check if invoice already exists for this termin
        $exists = Invoice::where('project_id', $project->id)
            ->where('termin_percentage', $terminPercentage)
            ->exists();

        if (!$exists) {
            $admins = User::where('role', 'admin')->where('is_active', true)->pluck('email');

            if ($admins->isNotEmpty()) {
                Mail::to($admins)->send(new InvoiceTerminNotification($project, $terminPercentage));
            }
        }
    }

    public function checkAndNotifyTermin(Project $project): void
    {
        $terminTriggers = [30, 50, 70, 100];

        foreach ($terminTriggers as $termin) {
            if ($project->progress_percentage >= $termin) {
                $this->notifyInvoiceRequired($project, $termin);
            }
        }
    }

    public function checkOverdueInvoices(): void
    {
        Invoice::where('status', 'sent')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);
    }

    public function calculateTerminAmount(Project $project, int $terminPercentage): float
    {
        if (!$project->contract_value) {
            return 0;
        }

        return ($project->contract_value * $terminPercentage) / 100;
    }
}
