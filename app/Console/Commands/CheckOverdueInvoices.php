<?php

namespace App\Console\Commands;

use App\Services\InvoiceService;
use Illuminate\Console\Command;

class CheckOverdueInvoices extends Command
{
    protected $signature = 'invoice:check-overdue';
    protected $description = 'Check and update overdue invoices';

    public function handle(InvoiceService $invoiceService)
    {
        $invoiceService->checkOverdueInvoices();
        $this->info('Overdue invoices check completed.');
        return Command::SUCCESS;
    }
}
