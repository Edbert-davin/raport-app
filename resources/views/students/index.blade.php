@extends('layouts.app')
@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Daftar Siswa</h2>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="p-3">Nama</th>
                <th class="p-3">Panggilan</th>
                <th class="p-3">Kelas</th>
                <th class="p-3 text-center">Kelola Nilai & Raport</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $student->name }}</td>
                <td class="p-3">{{ $student->nickname }}</td>
                <td class="p-3">{{ $student->classroom->name ?? $student->kelas }}</td>
                <td class="p-3 text-center space-x-2">
                    <!-- Tombol Input / Edit Nilai -->
                    <a href="{{ route('scores.create', ['student' => $student->id, 'semester' => 1]) }}" class="inline-block bg-gray-100 text-gray-700 border px-3 py-1.5 rounded text-xs hover:bg-gray-200 transition">
                        ✏️ Input Nilai
                    </a>

                    <!-- Tombol Preview Raport Semester 1 -->
                    <a href="{{ route('scores.previewRaport', ['student' => $student->id, 'semester' => 1]) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600 transition">
                        Semester 1
                    </a>

                    <!-- Tombol Preview Raport Semester 2 -->
                    <a href="{{ route('scores.previewRaport', ['student' => $student->id, 'semester' => 2]) }}" class="inline-block bg-emerald-500 text-white px-4 py-2 rounded text-sm hover:bg-emerald-600 transition">
                        Semester 2
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection