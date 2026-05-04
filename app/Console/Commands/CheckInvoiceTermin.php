<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Services\InvoiceService;
use Illuminate\Console\Command;

class CheckInvoiceTermin extends Command
{
    protected $signature = 'invoice:check-termin';
    protected $description = 'Check project progress and notify admin for invoice creation';

    public function handle(InvoiceService $invoiceService)
    {
        $projects = Project::where('status', 'in_progress')->get();
        
        $this->info("Checking {$projects->count()} active projects...");

        foreach ($projects as $project) {
            $terminTriggers = [30, 50, 70, 100];
            
            foreach ($terminTriggers as $termin) {
                if ($project->progress_percentage >= $termin) {
                    $invoiceService->notifyInvoiceRequired($project, $termin);
                    $this->info("Termin {$termin}% reached for project: {$project->name}");
                }
            }
        }

        $this->info('Invoice termin check completed.');
        
        return Command::SUCCESS;
    }
}
