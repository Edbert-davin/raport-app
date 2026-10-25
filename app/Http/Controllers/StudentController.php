<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Untuk MVP, kita tampilkan semua siswa dengan relasi kelasnya
        $students = Student::with('classroom')->get();
        return view('students.index', compact('students'));
    }
}
