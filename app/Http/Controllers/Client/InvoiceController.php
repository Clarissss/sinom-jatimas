<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $projectIds = auth()->user()->projects()->pluck('id');

        $query = Invoice::with('project')
            ->whereIn('project_id', $projectIds);

        // Jika filter project dipilih, tambahkan kondisi where untuk memfilter berdasarkan project_id
         if ($request->filled('project_id')) {

            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('project_id')) {

            $query->where('project_id', $request->project_id);
        }

        // Jika filter status dipilih, tambahkan kondisi where untuk memfilter berdasarkan status
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        $invoices = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $projects = auth()->user()->projects;

        return view('client.invoices.index', compact(
            'invoices',
            'projects'
        ));
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice->project);

        $invoice->load([
            'project.client',
            'items',
            'creator'
        ]);

        return view('client.invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $this->authorize('view', $invoice->project);

        if (
            !$invoice->pdf_path ||
            !Storage::disk('private')->exists($invoice->pdf_path)
        ) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        return Storage::disk('private')->download(
            $invoice->pdf_path,
            "Invoice_{$invoice->invoice_number}.pdf"
        );
    }
}