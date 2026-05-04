@extends('layouts.app')

@section('title', 'Edit Dokumen - PT. Sinom Jati Mas')
@section('page-title', 'Edit Dokumen')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.documents.update', $document) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Dokumen</label>
                <select name="type" class="w-full border-gray-300 rounded-lg">
                    <option value="contract" {{ $document->type == 'contract' ? 'selected' : '' }}>Kontrak Kerja</option>
                    <option value="technical_drawing" {{ $document->type == 'technical_drawing' ? 'selected' : '' }}>Gambar Teknis</option>
                    <option value="bast" {{ $document->type == 'bast' ? 'selected' : '' }}>BAST</option>
                    <option value="material_report" {{ $document->type == 'material_report' ? 'selected' : '' }}>Laporan Material</option>
                    <option value="other" {{ $document->type == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.documents.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
