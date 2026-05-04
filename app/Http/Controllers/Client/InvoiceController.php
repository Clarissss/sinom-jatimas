<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index()
    {
        $projectIds = auth()->user()->projects()->pluck('id');
        
        $invoices = Invoice::with('project')
            ->whereIn('project_id', $projectIds)
            ->latest()
            ->paginate(15);

        return view('client.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice->project);

        $invoice->load(['project.client']);
        
        return view('client.invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $this->authorize('view', $invoice->project);

        if (!$invoice->pdf_path || !Storage::exists($invoice->pdf_path)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        return Storage::download($invoice->pdf_path, "Invoice_{$invoice->invoice_number}.pdf");
    }
}
