@extends('layouts.app')

@section('title', 'Invoice Saya - PT. Sinom Jati Mas')
@section('page-title', 'Invoice Saya')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    .ts-control {
        border-radius: 0.75rem !important;
        padding: 0.6rem 0.75rem !important;
        border-color: #f3f4f6 !important;
        background-color: #f9fafb !important;
        font-size: 0.875rem !important;
    }

    .ts-wrapper.focus .ts-control {
        border-color: #DD3517 !important;
        box-shadow: 0 0 0 2px rgba(221, 53, 23, 0.1) !important;
    }

    .ts-dropdown {
        border-radius: 1rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<div class="space-y-6 animate-fade-in">

    {{-- HEADER --}}
        <div class="flex justify-between items-end px-2">

        <div>

            <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase">
                INVOICE PROYEK
            </h2>

            <p class="text-sm text-gray-500 mt-2 font-medium">
                Monitoring tagihan dan status pembayaran proyek Anda.
            </p>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100"
         x-data="{
            init() {

                new TomSelect('#filter_project', {

                    plugins: ['clear_button'],

                    render: {

                        option: (data, escape) =>
                            `<div>
                                <span class='mr-2 text-gray-400'>
                                    <i class='fas fa-helmet-safety w-4'></i>
                                </span>
                                ${escape(data.text)}
                            </div>`,

                        item: (data, escape) =>
                            `<div>
                                <span class='mr-2 text-[#DD3517]'>
                                    <i class='fas fa-helmet-safety w-4'></i>
                                </span>
                                ${escape(data.text)}
                            </div>`
                    }
                });
            }
         }">

        <form action="{{ route('client.invoices.index') }}"
              method="GET"
              class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 items-end">

            {{-- PROJECT --}}
            <div>

                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">
                    Pilih Proyek
                </label>

                <select
                    name="project_id"
                    id="filter_project"
                    placeholder="Cari Proyek...">

                    <option value="">
                        Semua Proyek
                    </option>

                    @foreach($projects as $project)

                        <option
                            value="{{ $project->id }}"
                            {{ request('project_id') == $project->id ? 'selected' : '' }}>

                            {{ $project->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- STATUS --}}
            <div>

                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">
                    Status Invoice
                </label>

                <select
                    name="status"
                    class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm focus:ring-[#DD3517] px-3    focus:border-[#DD3517] h-[46px] font-bold transition-all uppercase tracking-tighter">

                    <option value="">
                        SEMUA STATUS
                    </option>

                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                        DRAFT
                    </option>

                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>
                        TERKIRIM
                    </option>

                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>
                        LUNAS
                    </option>

                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>
                        JATUH TEMPO
                    </option>

                </select>

            </div>

            {{-- BUTTON --}}
            <div class="flex space-x-2 h-[46px]">

                <button
                    type="submit"
                    class="flex-1 bg-gray-900 text-white rounded-xl hover:bg-black text-[10px] font-black uppercase tracking-widest transition-all shadow-md">

                    <i class="fas fa-filter mr-1 text-[8px]"></i>
                    Terapkan

                </button>

                @if(request()->anyFilled(['project_id', 'status']))

                    <a href="{{ route('client.invoices.index') }}"
                       class="w-14 inline-flex items-center justify-center bg-gray-100 text-gray-400 rounded-xl hover:bg-gray-200 transition-all shadow-sm">

                        <i class="fas fa-rotate-left"></i>

                    </a>

                @endif

            </div>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-50 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50/50 border-b border-gray-100">

                    <tr>

                        <th class="px-8 py-6 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                            No. Invoice
                        </th>

                        <th class="px-8 py-6 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                            Proyek
                        </th>

                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                            Termin
                        </th>

                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                            Progress
                        </th>

                        <th class="px-8 py-6 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                            Total Tagihan
                        </th>

                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                            Status
                        </th>

                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                            Opsi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-50">

                    @forelse($invoices as $invoice)

                        <tr class="hover:bg-gray-50/80 transition-all">

                            <td class="px-8 py-5">

                                <span class="font-black text-gray-900 tracking-tight">
                                    {{ $invoice->invoice_number }}
                                </span>

                                <div class="text-[9px] text-gray-400 font-bold mt-1 uppercase">
                                    Diterbitkan:
                                    {{ $invoice->created_at->format('d/m/Y') }}
                                </div>

                            </td>

                            <td class="px-8 py-5">

                                <div class="font-black text-gray-800 text-sm uppercase tracking-tight">
                                    {{ $invoice->project->name }}
                                </div>

                            </td>

                            <td class="px-8 py-5 text-center">

                                <span class="px-3 py-1 bg-gray-100 rounded-lg text-[10px] font-black text-gray-600">
                                    {{ $invoice->termin_percentage }}%
                                </span>

                            </td>

                            <td class="px-8 py-5 text-center">

                                <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-lg text-[10px] font-black">
                                    {{ $invoice->project->progress_percentage }}%
                                </span>

                            </td>

                            <td class="px-8 py-5 text-right font-black text-[#DD3517] text-sm tracking-tighter">

                                Rp {{ number_format($invoice->amount, 0, ',', '.') }}

                            </td>

                            <td class="px-8 py-5 text-center">

                                @php

                                    $statusStyle = [

                                        'draft' => 'bg-gray-100 text-gray-500 border-gray-200',

                                        'sent' => 'bg-blue-50 text-blue-600 border-blue-100',

                                        'overdue' => 'bg-red-50 text-red-600 border-red-100',

                                        'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',

                                    ];

                                @endphp

                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusStyle[$invoice->status] ?? '' }}">

                                    <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $invoice->status === 'paid' ? 'bg-emerald-500' : ($invoice->status === 'overdue' ? 'bg-red-500 animate-pulse' : 'bg-current') }}"></span>

                                    {{ $invoice->status_label }}

                                </span>

                            </td>

                            <td class="px-8 py-5">

                                <div class="flex items-center justify-center space-x-1">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('client.invoices.show', $invoice) }}"
                                       class="w-9 h-9 flex items-center justify-center text-gray-400 hover:text-gray-900 hover:bg-white hover:shadow-sm rounded-xl transition-all">

                                        <i class="fa-solid fa-eye text-xs"></i>

                                    </a>

                                    {{-- DOWNLOAD --}}
                                    <a href="{{ route('client.invoices.download', $invoice) }}"
                                       class="w-9 h-9 flex items-center justify-center text-blue-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">

                                        <i class="fa-solid fa-file-pdf text-xs"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-8 py-24 text-center">

                                <div class="flex flex-col items-center opacity-30">

                                    <i class="fa-solid fa-file-invoice text-5xl mb-4"></i>

                                    <p class="text-xs font-black uppercase tracking-widest">
                                        Tidak ada invoice ditemukan
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($invoices->hasPages())

            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">

                {{ $invoices->links() }}

            </div>

        @endif

    </div>

</div>

@endsection