<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentDescription;
use Barryvdh\DomPDF\Facade\Pdf;

class MuridController extends Controller
{
    public function myRaport(Request $request)
    {
        $semester = $request->query('semester', 1);
        $user = Auth::user();
        
        $student = $user->student;
        
        if (!$student) {
            abort(404, 'Data siswa belum dihubungkan ke akun ini.');
        }

        $descriptions = StudentDescription::with('aspect')
            ->where('student_id', $student->id)
            ->where('semester', $semester)
            ->get();

        return view('murid.raport', compact('student', 'semester', 'descriptions'));
    }

    public function exportPdf(Request $request)
    {
        $semester = $request->query('semester', 1);
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            abort(404, 'Data siswa tidak ditemukan.');
        }

        $descriptions = StudentDescription::with('aspect')
            ->where('student_id', $student->id)
            ->where('semester', $semester)
            ->get();

        if ($descriptions->isEmpty()) {
            return back()->with('error', 'Raport semester ini belum tersedia untuk dicetak.');
        }

        // Render view khusus PDF
        $pdf = Pdf::loadView('pdf.raport', compact('student', 'semester', 'descriptions'));
        
        // Atur ukuran kertas (opsional, default A4 portrait)
        $pdf->setPaper('A4', 'portrait');

        // Menghasilkan nama file yang dinamis
        $fileName = 'Raport_' . str_replace(' ', '_', $student->name) . '_Semester_' . $semester . '.pdf';

        return $pdf->download($fileName);
    }
}