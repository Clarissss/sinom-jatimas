@extends('layouts.app')

@section('title', 'Kelola Invoice - PT. Sinom Jati Mas')
@section('page-title', 'Kelola Invoice')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
    /* Konsistensi styling Tom Select dengan tema branding Sinom */
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
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Daftar Invoice</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Monitoring status finansial dan termin pembayaran proyek.</p>
        </div>
        <a href="{{ route('admin.invoices.create') }}" 
           class="inline-flex items-center justify-center px-8 py-3 bg-[#DD3517] text-white text-[10px] font-black rounded-2xl hover:bg-[#FF812E] transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-red-100 uppercase tracking-widest">
            <i class="fas fa-plus mr-2"></i> Buat Invoice Baru
        </a>
    </div>

    {{-- Filter Bar (Gaya Laporan Harian - Tanggal Dihapus) --}}
    <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100"
         x-data="{
            init() {
                new TomSelect('#filter_client', {
                    plugins: ['clear_button'],
                    render: {
                        option: (data, escape) => `<div><span class='mr-2 text-gray-400'><i class='fas fa-user-tie w-4'></i></span>${escape(data.text)}</div>`,
                        item: (data, escape) => `<div><span class='mr-2 text-[#DD3517]'><i class='fas fa-user-tie w-4'></i></span>${escape(data.text)}</div>`
                    }
                });
                new TomSelect('#filter_project', {
                    plugins: ['clear_button'],
                    render: {
                        option: (data, escape) => `<div><span class='mr-2 text-gray-400'><i class='fas fa-helmet-safety w-4'></i></span>${escape(data.text)}</div>`,
                        item: (data, escape) => `<div><span class='mr-2 text-[#DD3517]'><i class='fas fa-helmet-safety w-4'></i></span>${escape(data.text)}</div>`
                    }
                });
            }
         }">
        <form action="{{ route('admin.invoices.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 items-end">
            
            {{-- Filter Klien --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Pilih Klien</label>
                <select name="client_id" id="filter_client" placeholder="Cari Klien...">
                    <option value="">Semua Klien</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Proyek --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Pilih Proyek</label>
                <select name="project_id" id="filter_project" placeholder="Cari Proyek...">
                    <option value="">Semua Proyek</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Status --}}
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Status Tagihan</label>
                <select name="status" class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm focus:ring-[#DD3517] focus:border-[#DD3517] h-[46px] font-bold transition-all uppercase tracking-tighter">
                    <option value="">SEMUA STATUS</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>DRAFT</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>TERKIRIM</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>LUNAS</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>JATUH TEMPO</option>
                </select>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-2 h-[46px]">
                <button type="submit" class="flex-1 bg-gray-900 text-white rounded-xl hover:bg-black text-[10px] font-black uppercase tracking-widest transition-all shadow-md">
                    <i class="fas fa-filter mr-1 text-[8px]"></i> Terapkan
                </button>
                @if(request()->anyFilled(['client_id', 'project_id', 'status']))
                    <a href="{{ route('admin.invoices.index') }}" class="w-14 inline-flex items-center justify-center bg-gray-100 text-gray-400 rounded-xl hover:bg-gray-200 transition-all shadow-sm">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-8 py-6 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">No. Invoice</th>
                        <th class="px-8 py-6 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Klien & Proyek</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Termin</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Progress</th>
                        <th class="px-8 py-6 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total Tagihan</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-6 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50/80 transition-all">
                            <td class="px-8 py-5">
                                <span class="font-black text-gray-900 tracking-tight">{{ $invoice->invoice_number }}</span>
                                <div class="text-[9px] text-gray-400 font-bold mt-1 uppercase">Diterbitkan: {{ $invoice->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="font-black text-gray-800 text-sm uppercase tracking-tight">{{ $invoice->project->name }}</div>
                                <div class="text-xs text-gray-500 font-medium mt-0.5">{{ $invoice->project->client->name }}</div>
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
                                    <a href="{{ route('admin.invoices.show', $invoice) }}" class="w-9 h-9 flex items-center justify-center text-gray-400 hover:text-gray-900 hover:bg-white hover:shadow-sm rounded-xl transition-all"><i class="fa-solid fa-eye text-xs"></i></a>
                                    <a href="{{ route('admin.invoices.download', $invoice) }}" class="w-9 h-9 flex items-center justify-center text-blue-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"><i class="fa-solid fa-file-pdf text-xs"></i></a>
                                    
                                    @if(in_array($invoice->status, ['sent', 'overdue']))
                                        <button type="button"
                                                x-data="{}"
                                                @click="$dispatch('open-confirm', {
                                                    title: 'Konfirmasi Pelunasan',
                                                    message: 'Tandai invoice {{ $invoice->invoice_number }} sebagai lunas?',
                                                    action: '{{ route('admin.invoices.mark-paid', $invoice) }}',
                                                    method: 'POST',
                                                    buttonText: 'Tandai Lunas',
                                                    buttonClass: 'bg-emerald-600 hover:bg-emerald-700',
                                                    icon: 'fa-check-double'
                                                })"
                                                class="w-9 h-9 flex items-center justify-center text-emerald-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all"
                                                title="Tandai Lunas">
                                            <i class="fa-solid fa-check-double text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <i class="fa-solid fa-file-invoice text-5xl mb-4"></i>
                                    <p class="text-xs font-black uppercase tracking-widest">Tidak ada invoice ditemukan</p>
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