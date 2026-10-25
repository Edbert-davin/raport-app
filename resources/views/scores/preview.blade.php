@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-start mb-6 border-b pb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Review & Edit Narasi: {{ $student->nama ?? $student->name }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Sistem telah menyusun narasi awal berdasarkan nilai dominan. Anda dapat menyesuaikan teks di bawah ini agar lebih personal.
            </p>
        </div>
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
            Semester {{ $semester }}
        </span>
    </div>

    <!-- Form Edit Narasi -->
    <form action="{{ route('scores.updatePreview', $student->id) }}" method="POST">
        @csrf
        <input type="hidden" name="semester" value="{{ $semester }}">

        @forelse($descriptions as $desc)
        <div class="mb-6 border-b pb-4">
            <label class="block text-gray-700 font-bold mb-2">
                Aspek: {{ $desc->aspect->nama_aspek ?? $desc->aspect->name ?? 'Aspek Perkembangan' }}
            </label>
            <textarea 
                name="descriptions[{{ $desc->id }}]" 
                rows="4" 
                class="w-full border-gray-300 border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 leading-relaxed text-gray-700 text-sm"
                required
            >{{ $desc->final_text }}</textarea>
        </div>
        @empty
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-md mb-6 text-sm text-center">
            Belum ada narasi yang di-generate. Silakan input nilai terlebih dahulu.
        </div>
        @endforelse

        <!-- Tombol Aksi -->
        <div class="flex flex-wrap gap-4 items-center justify-between pt-2">
            <a href="{{ route('scores.create', ['student' => $student->id, 'semester' => $semester]) }}" 
               class="text-gray-600 border border-gray-300 py-2 px-5 rounded-lg hover:bg-gray-100 text-sm font-medium transition">
                ← Kembali Edit Nilai (Akan me-reset narasi)
            </a>

            @if($descriptions->isNotEmpty())
            <button type="submit" 
                    class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 text-sm transition shadow-sm">
                Simpan Final Narasi
            </button>
            @endif
        </div>
    </form>
</div>
@endsection