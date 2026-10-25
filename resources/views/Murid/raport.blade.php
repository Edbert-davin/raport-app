@extends('layouts.app')
@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center border-b pb-4 mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-semibold mb-1">Raport: {{ $student->name }}</h2>
            <p class="text-gray-600">Kelas: {{ $student->classroom->name }}</p>
        </div>
        
        <div class="flex items-center gap-4">
            <!-- Filter Semester -->
            <form action="{{ route('murid.raport') }}" method="GET" class="flex items-center gap-2">
                <label for="semester" class="font-bold text-gray-700 text-sm">Semester:</label>
                <select name="semester" id="semester" onchange="this.form.submit()" class="border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1 px-2 text-sm">
                    <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2</option>
                </select>
            </form>

            <!-- Tombol Cetak PDF -->
            @if($descriptions->isNotEmpty())
                <a href="{{ route('murid.raport.pdf', ['semester' => $semester]) }}" target="_blank" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600 flex items-center gap-2 text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak PDF
                </a>
            @endif
        </div>
    </div>

    @if($descriptions->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-4 rounded-lg flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>Raport untuk <strong>Semester {{ $semester }}</strong> belum difinalisasi oleh guru.</span>
        </div>
    @else
        <div class="space-y-6">
            @foreach($descriptions as $desc)
            <div class="bg-blue-50 p-5 rounded-lg border border-blue-100">
                <h3 class="text-lg font-bold text-blue-700 mb-2">{{ $desc->aspect->name }}</h3>
                <p class="text-gray-800 leading-relaxed text-justify">
                    {{ $desc->final_text }}
                </p>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection