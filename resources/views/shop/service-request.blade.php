@extends('layouts.storefront')

@section('title', 'Request Service — KeeHub')

@section('content')
<div class="x-container py-8">
    <h1 class="x-section-title">Request Service</h1>
    <p class="mt-1 text-sm text-gray-500">Ceritakan kendala PC kamu — tim teknisi KeeHub akan mendiagnosis dan memberi estimasi biaya.</p>

    @if (session('success'))
        <div class="mt-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-400">
            {{ session('success') }}
            @if (session('wa_link'))
                <a href="{{ session('wa_link') }}" target="_blank" rel="noopener" class="mt-2 block font-bold text-green-700 underline dark:text-green-400">Konfirmasi via WhatsApp →</a>
            @endif
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-600 dark:bg-red-900/30 dark:text-red-400">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('service.store') }}" class="x-card mt-6 max-w-2xl p-6">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" required class="x-input" placeholder="Nama kamu">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required class="x-input" placeholder="08xxxxxxxxxx">
            </div>
        </div>

        <div class="mt-4">
            <label class="mb-1 block text-sm font-medium">Jenis Service</label>
            <select name="service_type" required class="x-input">
                <option value="">— Pilih jenis —</option>
                @foreach ($serviceTypes as $key => $label)
                    <option value="{{ $key }}" @selected(old('service_type') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label class="mb-1 block text-sm font-medium">Deskripsi Kendala</label>
            <textarea name="problem_description" rows="4" required class="x-input" placeholder="Contoh: PC mati total, sudah coba ganti PSU tetap tidak menyala.">{{ old('problem_description') }}</textarea>
        </div>

        <div class="mt-4">
            <label class="mb-1 block text-sm font-medium">Komponen Bawaan Sendiri <span class="font-normal text-gray-400">(opsional)</span></label>
            <textarea name="owned_components" rows="3" class="x-input" placeholder="Contoh:&#10;CPU: Ryzen 5 5600&#10;Motherboard: B550M&#10;RAM: 16GB&#10;GPU: RTX 4060"></textarea>
            <p class="mt-1 text-xs text-gray-400">Komponen bawaan ditandai CUSTOMER OWNED — tidak mengurangi stok toko, hanya jasa yang ditagih.</p>
        </div>

        <button type="submit" class="x-btn-primary mt-6 w-full">Kirim Request Service</button>
    </form>
</div>
@endsection
