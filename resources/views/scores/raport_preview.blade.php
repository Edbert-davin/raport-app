@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto print:shadow-none print:p-0 print:max-w-none print:w-full">

    <!-- Tombol Navigasi & Cetak (Hanya Tampil di Layar Browser) -->
    <div class="flex justify-between items-center border-b pb-4 mb-6 print:hidden">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Preview Raport Siswa</h2>
            <p class="text-xs text-gray-500">Gunakan tombol cetak untuk menyimpan sebagai PDF atau mencetak ke kertas.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('students.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm font-medium hover:bg-gray-300 transition">
                ← Kembali
            </a>
            <button onclick="window.print()" class="bg-green-600 text-white px-5 py-2 rounded text-sm font-semibold hover:bg-green-700 transition shadow">
                🖨️ Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- KOP RAPORT RESMI -->
    <div class="text-center border-b-2 border-gray-900 pb-4 mb-6">
        <h1 class="text-2xl font-bold uppercase tracking-wider text-gray-900">RAPORT PAUD DIGITAL</h1>
        <p class="text-sm text-gray-700 font-semibold mt-1">LAPORAN CAPAIAN PERKEMBANGAN ANAK</p>
        <p class="text-xs text-gray-500 mt-0.5">Semester {{ $semester }} ({{ $semester == 1 ? 'Ganjil' : 'Genap' }})</p>
    </div>

    <!-- IDENTITAS SISWA -->
    <div class="mb-6 text-sm border border-gray-300 print:border-gray-800 rounded-md p-4 bg-gray-50 print:bg-transparent">
        <div class="grid grid-cols-2 gap-y-2">
            <div>
                <span class="text-gray-600 print:text-gray-800">Nama Peserta Didik:</span>
                <strong class="ml-2 text-gray-900">{{ $student->name ?? $student->nama }}</strong>
            </div>
            <div>
                <span class="text-gray-600 print:text-gray-800">Kelas / Kelompok:</span>
                <strong class="ml-2 text-gray-900">{{ $student->classroom->name ?? $student->kelas }}</strong>
            </div>
            <div>
                <span class="text-gray-600 print:text-gray-800">Nama Panggilan:</span>
                <strong class="ml-2 text-gray-900">{{ $student->nickname ?? $student->panggilan }}</strong>
            </div>
            <div>
                <span class="text-gray-600 print:text-gray-800">Semester:</span>
                <strong class="ml-2 text-gray-900">{{ $semester }}</strong>
            </div>
        </div>
    </div>

    <!-- TABEL HASIL NARASI PENILAIAN -->
    <div class="mb-8">
        <h3 class="font-bold text-gray-900 mb-2 text-sm uppercase tracking-wide">A. CAPAIAN PERKEMBANGAN ANAK</h3>
        <table class="w-full text-left text-sm border-collapse border border-gray-400">
            <thead>
                <tr class="bg-gray-100 print:bg-gray-200 text-gray-900">
                    <th class="p-3 border border-gray-400 font-bold w-1/3 text-center">Aspek Perkembangan</th>
                    <th class="p-3 border border-gray-400 font-bold text-center">Capaian & Narasi Penilaian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($descriptions as $desc)
                <tr>
                    <td class="p-3 border border-gray-400 font-semibold text-gray-900 align-top bg-gray-50 print:bg-transparent">
                        {{ $desc->aspect->name ?? $desc->aspect->nama_aspek ?? 'Aspek Perkembangan' }}
                    </td>
                    <td class="p-3 border border-gray-400 text-gray-800 leading-relaxed text-justify align-top">
                        {{ $desc->final_text }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="p-4 border border-gray-400 text-center text-gray-500 italic">
                        Belum ada data nilai/narasi yang disimpan untuk semester ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- KOLOM TANDA TANGAN -->
    <div class="mt-12 pt-4 text-sm grid grid-cols-2 gap-8 text-center print:break-inside-avoid">
        <div>
            <p class="mb-16">Mengetahui,<br><strong>Orang Tua / Wali Murid</strong></p>
            <p class="border-b border-gray-800 inline-block w-56 font-semibold"></p>
        </div>
        <div>
            <p class="mb-16">
                Guru Kelas / Wali Kelas
            </p>
            <p class="border-b border-gray-800 inline-block w-56 font-semibold">{{ Auth::user()->name ?? 'Guru Kelas' }}</p>
        </div>
    </div>

</div>
@endsection