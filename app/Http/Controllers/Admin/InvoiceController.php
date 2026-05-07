<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use App\Models\User;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{

    protected $invoiceService;

    

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(Request $request)
{
    $query = Invoice::with(['project.client']);

    // Logika Filter
    if ($request->filled('client_id')) {
        $query->whereHas('project', function($q) use ($request) {
            $q->where('client_id', $request->client_id);
        });
    }

    if ($request->filled('project_id')) {
        $query->where('project_id', $request->project_id);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $invoices = $query->latest()->paginate(15)->withQueryString();
    
    // Data untuk Dropdown Filter
    $clients = User::where('role', 'client')->orderBy('name')->get();
    $projects = Project::orderBy('name')->get();

    return view('admin.invoices.index', compact('invoices', 'clients', 'projects'));
}

    public function create()
    {
        $clients = User::where('role', '!=', 'admin')->get();
        $projects = Project::where('status', 'in_progress')->get();
        
        return view('admin.invoices.create', compact('clients', 'projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'termin_percentage' => 'required|numeric|min:1|max:100',
            'due_date' => 'nullable|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $invoiceNumber = $this->invoiceService->generateInvoiceNumber();
            
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += ($item['quantity'] * $item['price']);
            }

            $invoice = Invoice::create([
                'project_id' => $validated['project_id'],
                'invoice_number' => $invoiceNumber,
                'amount' => $grandTotal,
                'termin_percentage' => $validated['termin_percentage'],
                'due_date' => $validated['due_date'],
                'created_by' => auth()->id(),
                'status' => 'sent', 
            ]);

            foreach ($request->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);
            }

            $this->generatePdf($invoice);

            $dueDateFormatted = $invoice->due_date ? Carbon::parse($invoice->due_date)->format('d/m/Y') : '-';
            $formattedTotal = number_format($grandTotal, 0, ',', '.');
            
            $chatMessage = ChatMessage::create([
                'project_id' => $invoice->project_id,
                'sender_id' => auth()->id(),
                'message' => "📄 *INVOICE BARU DITERBITKAN*\n\nNo. Invoice: {$invoice->invoice_number}\nTermin: {$invoice->termin_percentage}%\nTotal Tagihan: Rp {$formattedTotal}\nJatuh Tempo: {$dueDateFormatted}",
                'file_path' => $invoice->pdf_path, 
                'file_name' => "Invoice_{$invoice->invoice_number}.pdf",
                'file_type' => 'pdf',
                'file_size' => Storage::disk('private')->size($invoice->pdf_path),
                'is_read' => false,
            ]);

            DB::commit();

            try {
                $chatMessage->load('sender');
                broadcast(new MessageSent($chatMessage))->toOthers();
            } catch (\Exception $e) {
                Log::error("Pusher Broadcast Error: " . $e->getMessage());
            }

            return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil dibuat dan dikirim ke Chat.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Invoice Store Error: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form untuk mengedit invoice.
     */
    public function edit(Invoice $invoice)
    {
    $invoice->load(['project', 'items']); 
    $clients = User::where('role', '!=', 'admin')->get();
    $projects = Project::all();
    
    return view('admin.invoices.edit', compact('invoice', 'clients', 'projects')); }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'termin_percentage' => 'required|numeric|min:1|max:100',
            'due_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += ($item['quantity'] * $item['price']);
            }

            $invoice->update([
                'project_id' => $validated['project_id'],
                'amount' => $grandTotal,
                'termin_percentage' => $validated['termin_percentage'],
                'due_date' => $validated['due_date'],
            ]);

            // Hapus item lama dan masukkan yang baru untuk menjaga integritas data [cite: 17]
            $invoice->items()->delete();

            foreach ($request->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);
            }

            // Update file PDF [cite: 34]
            $this->generatePdf($invoice);

            DB::commit();
            return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Invoice Update Error: " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['project.client', 'creator', 'items']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        if (!$invoice->pdf_path || !Storage::disk('private')->exists($invoice->pdf_path)) {
            $this->generatePdf($invoice);
        }

        return Storage::disk('private')->download($invoice->pdf_path, "Invoice_{$invoice->invoice_number}.pdf");
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

        return back()->with('success', 'Invoice berhasil dikirim.');
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
            Storage::disk('private')->delete($invoice->pdf_path);
        }
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }

    protected function generatePdf(Invoice $invoice)
    {
        $invoice->load(['project.client', 'items']);
        
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
        
        $filename = "invoice_{$invoice->invoice_number}.pdf";
        $path = "chat-files/{$filename}"; 
        
        Storage::disk('private')->put($path, $pdf->output());
        
        $invoice->update(['pdf_path' => $path]);
    }
}