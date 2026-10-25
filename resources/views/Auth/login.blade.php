@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login Sistem Raport</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="guru@paud.com">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="password123">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">
            Login
        </button>
    </form>

    <div class="mt-6 text-sm text-gray-500 bg-gray-50 p-4 rounded border">
        <p class="font-bold mb-1">Akun Dummy (Password: password123):</p>
        <ul class="list-disc pl-4 space-y-1">
            <li>Guru: guru@paud.com</li>
            <li>Murid 1: budi@paud.com</li>
            <li>Murid 2: siti@paud.com</li>
        </ul>
    </div>
</div>
@endsection