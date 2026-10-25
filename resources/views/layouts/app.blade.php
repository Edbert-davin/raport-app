<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Raport PAUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sembunyikan elemen web tidak penting saat dicetak/diprint */
        @media print {
            body { background: white !important; color: black !important; }
            header, nav, .print\:hidden { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    <!-- Navbar utama (Otomatis disembunyikan saat dicetak) -->
    @auth
    <nav class="bg-blue-600 text-white shadow-md print:hidden">
        <div class="max-w-5xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Raport PAUD Digital</h1>

            <div class="flex items-center gap-6">
                {{-- Menu navigasi khusus Guru --}}
                @if(Auth::user()->isGuru())
                    <a href="{{ route('students.index') }}" class="text-white hover:text-gray-200 text-sm font-medium">Data Siswa (Input Nilai)</a>
                    <a href="{{ route('aspects.index') }}" class="text-white hover:text-gray-200 text-sm font-medium">Master Mata Pelajaran</a>
                    <a href="{{ route('aspects.index') }}" class="text-white hover:text-gray-200 text-sm font-medium">Master Mata Penguna</a>
                @endif

                <span class="text-sm border-l border-blue-400 pl-6">Halo, {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm font-semibold transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Konten Utama -->
    <main class="max-w-5xl mx-auto p-6 print:p-0 print:max-w-none">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 print:hidden">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>