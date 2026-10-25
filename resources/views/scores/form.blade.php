@extends('layouts.app')
@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-2">Input Nilai: {{ $student->name }}</h2>
    <p class="text-gray-600 mb-6">Semester: {{ $semester }} | Kelas: {{ $student->classroom->name }}</p>

    <form action="{{ route('scores.store', $student->id) }}" method="POST">
        @csrf
        <input type="hidden" name="semester" value="{{ $semester }}">

        @foreach($aspects as $aspect)
        <div class="mb-6">
            <h3 class="text-lg font-bold bg-blue-100 p-2 rounded">{{ $aspect->name }}</h3>
            <table class="w-full mt-2 border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border w-1/2">Sub-Indikator</th>
                        <th class="p-2 border text-center">BB</th>
                        <th class="p-2 border text-center">MB</th>
                        <th class="p-2 border text-center">BSH</th>
                        <th class="p-2 border text-center">BSB</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspect->subIndicators as $ind)
                        @php 
                            $currentScore = $existingScores[$ind->id] ?? null; 
                        @endphp
                        <tr>
                            <td class="p-2 border">{{ $ind->description }}</td>
                            @foreach(['BB', 'MB', 'BSH', 'BSB'] as $scale)
                            <td class="p-2 border text-center">
                                <input type="radio" required name="scores[{{ $ind->id }}]" value="{{ $scale }}" {{ $currentScore === $scale ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        <div class="mt-6">
            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-6 rounded hover:bg-green-600 w-full">
                Simpan & Generate Deskripsi
            </button>
        </div>
    </form>
</div>
@endsection