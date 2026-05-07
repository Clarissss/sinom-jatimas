@extends('layouts.app')

@section('title', 'Edit Invoice - PT. Sinom Jati Mas')
@section('page-title', 'Edit Invoice')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp)</label>
                <input type="number" name="amount" value="{{ $invoice->amount }}" class="w-full border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jatuh Tempo</label>
                <input type="date" name="due_date" value="{{ $invoice->due_date?->format('Y-m-d') }}" class="w-full border-gray-300 rounded-lg">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.invoices.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
