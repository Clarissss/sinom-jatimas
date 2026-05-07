@extends('layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_number)
@section('page-title', 'Detail Invoice')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $invoice->invoice_number }}</h2>
                <p class="text-gray-600 mt-1">{{ $invoice->project->name }} - {{ $invoice->project->client->name }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-medium bg-{{ $invoice->status_color }}-100 text-{{ $invoice->status_color }}-800">
                {{ $invoice->status_label }}
            </span>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between py-3 border-b">
                <span class="text-gray-600">Termin</span>
                <span class="font-medium">{{ $invoice->termin_percentage }}%</span>
            </div>
            <div class="flex justify-between py-3 border-b">
                <span class="text-gray-600">Jumlah</span>
                <span class="font-medium">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between py-3 border-b">
                <span class="text-gray-600">Tanggal Dibuat</span>
                <span class="font-medium">{{ $invoice->created_at->format('d M Y') }}</span>
            </div>
            @if($invoice->due_date)
                <div class="flex justify-between py-3 border-b">
                    <span class="text-gray-600">Jatuh Tempo</span>
                    <span class="font-medium">{{ $invoice->due_date->format('d M Y') }}</span>
                </div>
            @endif
        </div>

        <div class="mt-6 flex space-x-3">
            <a href="{{ route('admin.invoices.download', $invoice) }}" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">Download PDF</a>
            @if($invoice->status === 'draft')
                <form action="{{ route('admin.invoices.send', $invoice) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Kirim ke Klien</button>
                </form>
            @endif
            <a href="{{ route('admin.invoices.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Kembali</a>
        </div>
    </div>
</div>
@endsection
