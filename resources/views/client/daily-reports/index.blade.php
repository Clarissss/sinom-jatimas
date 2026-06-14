@extends('layouts.app')

@section('title', 'Laporan Harian - PT. Sinom Jati Mas')
@section('page-title', 'Laporan Harian')

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
    </style>

    <div class="space-y-6 animate-fade-in pb-10">
        {{-- HEADER --}}
        <div class="flex justify-between items-end px-2">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">
                    Laporan Harian
                </h2>

                <p class="text-sm text-gray-500 mt-2 font-medium">
                    Monitoring aktivitas pengerjaan proyek Anda secara harian.
                </p>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100" x-data="{
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

            <form action="{{ route('client.daily-reports.index') }}" method="GET"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 items-end">

                {{-- FILTER PROYEK --}}
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">
                        Pilih Proyek
                    </label>

                    <select name="project_id" id="filter_project" placeholder="Cari Proyek...">
                        <option value="">
                            Semua Proyek
                        </option>

                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- FILTER TANGGAL --}}
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">
                        Pilih Tanggal
                    </label>

                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full border-gray-100 bg-gray-50 rounded-xl text-sm h-[46px] px-3 font-bold focus:ring-[#DD3517] focus:border-[#DD3517] transition-all">
                </div>

                {{-- BUTTON --}}
                <div class="flex space-x-2 h-[46px]">
                    <button type="submit"
                        class="flex-1 bg-gray-900 text-white rounded-xl hover:bg-black text-[10px] font-black uppercase tracking-widest transition-all shadow-md">

                        <i class="fas fa-filter mr-1 text-[8px]"></i>
                        Terapkan
                    </button>

                    @if (request()->anyFilled(['project_id', 'date']))
                        <a href="{{ route('client.daily-reports.index') }}"
                            class="w-14 inline-flex items-center justify-center bg-gray-100 text-gray-400 rounded-xl hover:bg-gray-200 transition-all shadow-sm">

                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                Tanggal
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                Proyek
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                Aktivitas
                            </th>

                            <th
                                class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                Cuaca
                            </th>

                            <th
                                class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                Foto
                            </th>

                            <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @forelse($reports as $report)
                            <tr class="hover:bg-gray-50/50 transition-colors group">

                                {{-- TANGGAL --}}
                                <td class="px-8 py-5">
                                    <p class="font-black text-gray-900 text-sm leading-none mb-1">
                                        {{ $report->report_date->format('d M Y') }}
                                    </p>

                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest italic">
                                        Dibuat oleh:
                                        {{ $report->creator->name ?? 'System' }}
                                    </p>
                                </td>

                                {{-- PROYEK --}}
                                <td class="px-8 py-5">
                                    <p class="text-sm font-black text-gray-900 leading-none uppercase tracking-tighter mb-1">
                                        {{ $report->project->name }}
                                    </p>
                                    <div>
                                        @if($report->is_accepted)
                                            <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[8px] px-2 py-0.5 rounded-md font-black">DITERIMA</span>
                                        @else
                                            <span class="bg-orange-50 text-orange-600 border border-orange-100 text-[8px] px-2 py-0.5 rounded-md font-black">BELUM DIKONFIRMASI</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- AKTIVITAS --}}
                                <td class="px-8 py-5">
                                    <p class="text-xs text-gray-600 line-clamp-2 max-w-xs font-medium">
                                        {{ $report->activity_description }}
                                    </p>
                                </td>

                                {{-- CUACA --}}
                                <td class="px-8 py-5 text-center">
                                    @php
                                        $weatherMap = [
                                            'sunny' => [
                                                'icon' => 'fa-sun',
                                                'color' => 'text-orange-500',
                                                'label' => 'CERAH',
                                            ],
                                            'cloudy' => [
                                                'icon' => 'fa-cloud',
                                                'color' => 'text-gray-400',
                                                'label' => 'BERAWAN',
                                            ],
                                            'rainy' => [
                                                'icon' => 'fa-cloud-showers-heavy',
                                                'color' => 'text-blue-500',
                                                'label' => 'HUJAN',
                                            ],
                                            'storm' => [
                                                'icon' => 'fa-bolt',
                                                'color' => 'text-purple-600',
                                                'label' => 'BADAI',
                                            ],
                                        ];
                                        $w = $weatherMap[$report->weather_condition] ?? $weatherMap['sunny'];
                                    @endphp

                                    <div class="{{ $w['color'] }} flex flex-col items-center">
                                        <i class="fa-solid {{ $w['icon'] }} text-sm mb-1"></i>
                                        <span class="text-[8px] font-black">
                                            {{ $w['label'] }}
                                        </span>
                                    </div>
                                </td>

                                {{-- FOTO --}}
                                <td class="px-8 py-5 text-center">
                                    @if ($report->photo)
                                        @php
                                            $allPhotos = explode(',', $report->photo);
                                            $firstPhoto = trim($allPhotos[0]);
                                        @endphp
                                        <div class="relative inline-block">
                                            <img src="{{ asset('storage/' . $firstPhoto) }}" class="w-10 h-10 rounded-xl object-cover border border-gray-100 shadow-sm mx-auto">
                                            @if(count($allPhotos) > 1)
                                                <span class="absolute -top-1.5 -right-1.5 bg-gray-900 text-white font-black text-[8px] px-1 py-0.5 rounded-md border border-white">
                                                    +{{ count($allPhotos) - 1 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <i class="fa-solid fa-image text-gray-200"></i>
                                    @endif

                                </td>

                                {{-- AKSI --}}
                                <td class="px-8 py-5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('client.daily-reports.show', $report) }}"
                                            class="p-2 bg-gray-50 text-gray-400 hover:text-blue-600 rounded-xl transition-all">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        @if(!$report->is_accepted)
                                            <button type="button"
                                                    x-data="{}"
                                                    @click="$dispatch('open-confirm', {
                                                        title: 'Terima Laporan Harian',
                                                        message: 'Konfirmasi bahwa Anda menyetujui laporan harian tanggal {{ $report->report_date->format('d/m/Y') }}? Setelah diterima, laporan tidak dapat diubah.',
                                                        action: '{{ route('client.daily-reports.accept', $report) }}',
                                                        method: 'PATCH',
                                                        buttonText: 'Terima',
                                                        buttonClass: 'bg-emerald-600 hover:bg-emerald-700',
                                                        icon: 'fa-check'
                                                    })"
                                                    class="inline-flex items-center px-3 py-1.5 bg-orange-50 text-orange-600 border border-orange-100 hover:bg-emerald-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all" title="Konfirmasi Terima Laporan">
                                                <i class="fa-solid fa-check mr-1"></i> Terima
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-clipboard-list text-4xl text-gray-100 mb-4"></i>
                                        <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">
                                            Laporan belum tersedia
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reports->hasPages())
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection