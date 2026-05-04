@extends('layouts.app')

@section('title', 'Invoice ' . $invoice->invoice_number)
@section('page-title', 'Detail Invoice')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Informasi Invoice</h3>
            @php
                $statusIcons = [
                    'draft' => '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
                    'sent' => '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>',
                    'overdue' => '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'paid' => '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                ];
            @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $invoice->status_color }}-100 text-{{ $invoice->status_color }}-800">
                {!! $statusIcons[$invoice->status] ?? '' !!}
                {{ $invoice->status_label }}
            </span>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <p class="text-sm text-gray-500 mb-1">Nomor Invoice</p>
                <h2 class="text-2xl font-bold text-gray-900">{{ $invoice->invoice_number }}</h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    {{ $invoice->project->name }}
                </p>
            </div>

            <div class="space-y-4 mb-6">
                <div class="flex justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Termin</span>
                    <span class="font-medium text-gray-900">{{ $invoice->termin_percentage }}%</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Jumlah</span>
                    <span class="font-bold text-gray-900">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Tanggal Dibuat</span>
                    <span class="font-medium text-gray-900">{{ $invoice->created_at->format('d M Y') }}</span>
                </div>
                @if($invoice->due_date)
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Jatuh Tempo</span>
                        <span class="font-medium text-gray-900">{{ $invoice->due_date->format('d M Y') }}</span>
                    </div>
                @endif
                @if($invoice->paid_at)
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Tanggal Dibayar</span>
                        <span class="font-medium text-green-600">{{ $invoice->paid_at->format('d M Y') }}</span>
                    </div>
                @endif
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <a href="{{ route('client.invoices.download', $invoice) }}" 
                   class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
