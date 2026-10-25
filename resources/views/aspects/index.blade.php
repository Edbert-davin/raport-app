@extends('layouts.app')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Master Data: Mata Pelajaran & Indikator</h2>
    <p class="text-gray-600 text-sm">Kelola mata pelajaran (aspek penilaian) yang akan muncul di form nilai raport.</p>
</div>

<!-- Form Tambah Mata Pelajaran -->
<div class="bg-white p-6 rounded-lg shadow-md mb-8 border-t-4 border-blue-500">
    <form action="{{ route('aspects.store') }}" method="POST" class="flex gap-4 items-end">
        @csrf
        <div class="flex-1">
            <label class="block text-gray-700 font-bold mb-2">Tambah Mata Pelajaran Baru</label>
            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Seni & Kreativitas">
        </div>
        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>

<!-- Daftar Mata Pelajaran -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($aspects as $aspect)
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        
        <!-- Header Mata Pelajaran -->
        <div class="bg-blue-50 p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-lg text-blue-800">{{ $aspect->name }}</h3>
            <form action="{{ route('aspects.destroy', $aspect->id) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini beserta semua nilainya?');">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Hapus</button>
            </form>
        </div>

        <!-- List Sub Indikator -->
        <div class="p-4">
            <ul class="list-disc pl-5 mb-4 text-gray-700 text-sm space-y-2">
                @forelse($aspect->subIndicators as $ind)
                <li class="flex justify-between items-start">
                    <span>{{ $ind->description }}</span>
                    <form action="{{ route('sub_indicators.destroy', $ind->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 ml-2 text-xs">✖</button>
                    </form>
                </li>
                @empty
                <li class="text-gray-400 italic list-none -ml-5">Belum ada sub-indikator.</li>
                @endforelse
            </ul>

            <!-- Form Tambah Sub Indikator -->
            <form action="{{ route('sub_indicators.store', $aspect->id) }}" method="POST" class="mt-4 flex gap-2">
                @csrf
                <input type="text" name="description" required class="flex-1 px-3 py-1 border border-gray-300 rounded text-sm focus:ring-blue-500" placeholder="Poin penilaian baru...">
                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Tambah</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection