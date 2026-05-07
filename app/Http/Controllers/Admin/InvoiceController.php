<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $invoices = Invoice::with(['project.client'])->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $projects = Project::where('status', 'in_progress')->get();
        return view('admin.invoices.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'termin_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $project = Project::find($validated['project_id']);
        $invoiceNumber = $this->invoiceService->generateInvoiceNumber();

        $invoice = Invoice::create([
            'project_id' => $validated['project_id'],
            'invoice_number' => $invoiceNumber,
            'amount' => $validated['amount'],
            'termin_percentage' => $validated['termin_percentage'],
            'due_date' => $validated['due_date'],
            'created_by' => auth()->id(),
            'status' => 'draft',
        ]);

        $this->generatePdf($invoice);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil dibuat.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['project.client', 'creator']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        if (!$invoice->pdf_path || !Storage::exists($invoice->pdf_path)) {
            $this->generatePdf($invoice);
        }

        return Storage::download($invoice->pdf_path, "Invoice_{$invoice->invoice_number}.pdf");
    }

    public function send(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return back()->with('error', 'Invoice sudah pernah dikirim.');
        }

        $invoice->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Invoice berhasil dikirim ke klien.');
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Invoice ditandai sebagai lunas.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->pdf_path) {
            Storage::delete($invoice->pdf_path);
        }
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }

    protected function generatePdf(Invoice $invoice)
    {
        $invoice->load('project.client');
        
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
        
        $filename = "invoice_{$invoice->invoice_number}.pdf";
        $path = "invoices/{$filename}";
        
        Storage::put($path, $pdf->output());
        
        $invoice->update(['pdf_path' => $path]);
    }
}
