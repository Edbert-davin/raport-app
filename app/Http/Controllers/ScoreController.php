<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Aspect;
use App\Models\Score;
use App\Models\DescriptionTemplate;
use App\Models\StudentDescription;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    // Form input nilai
    public function create(Student $student)
    {
        $semester = request('semester', 1);
        $aspects = Aspect::with('subIndicators')->get();

        // Ambil nilai yang sudah ada (jika mau edit)
        $existingScores = Score::where('student_id', $student->id)
            ->where('semester', $semester)
            ->pluck('scale', 'sub_indicator_id')
            ->toArray();

        return view('scores.form', compact('student', 'aspects', 'semester', 'existingScores'));
    }

    // Simpan nilai dan generate deskripsi
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'semester' => 'required|integer',
            'scores' => 'required|array', // format: scores[sub_indicator_id] = scale
        ]);

        $semester = $request->semester;

        // 1. Simpan nilai ke tabel scores
        foreach ($request->scores as $subIndicatorId => $scale) {
            Score::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'sub_indicator_id' => $subIndicatorId,
                    'semester' => $semester,
                ],
                ['scale' => $scale]
            );
        }

        // 2. Generate Deskripsi Naratif
        $this->generateNarrative($student, $semester);

        // 3. Arahkan ke halaman preview/edit narasi
        return redirect()->route('scores.preview', ['student' => $student->id, 'semester' => $semester])
            ->with('success', 'Nilai berhasil disimpan dan deskripsi otomatis di-generate!');
    }

    private function generateNarrative(Student $student, $semester)
    {
        $aspects = Aspect::with(['subIndicators.scores' => function ($query) use ($student, $semester) {
            $query->where('student_id', $student->id)->where('semester', $semester);
        }])->get();

        $scaleWeights = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
        $reverseScale = [1 => 'BB', 2 => 'MB', 3 => 'BSH', 4 => 'BSB'];

        foreach ($aspects as $aspect) {
            $scales = [];
            foreach ($aspect->subIndicators as $subInd) {
                $score = $subInd->scores->first();
                if ($score) {
                    $scales[] = $scaleWeights[$score->scale];
                }
            }

            if (count($scales) > 0) {
                // Cari modus (nilai paling sering muncul). Jika ada beberapa, ambil yang tertinggi.
                $counts = array_count_values($scales);
                arsort($counts);
                $maxCount = reset($counts);

                $modes = array_keys($counts, $maxCount);
                $dominantWeight = max($modes);
                $dominantScale = $reverseScale[$dominantWeight];

                // Ambil template acak untuk aspek dan skala ini
                $template = DescriptionTemplate::where('aspect_id', $aspect->id)
                    ->where('scale', $dominantScale)
                    ->inRandomOrder()
                    ->first();

                $finalText = "";
                if ($template) {
                    // String replacement untuk {nama} dan {panggilan}
                    $finalText = str_replace(
                        ['{nama}', '{nama_siswa}', '{panggilan}'],
                        [$student->nama ?? $student->name, $student->nama ?? $student->name, $student->panggilan ?? $student->nickname],
                        $template->template_text
                    );
                } else {
                    $finalText = "Siswa ini telah dinilai, namun template deskripsi untuk skala $dominantScale belum tersedia di sistem.";
                }

                // Simpan ke student_descriptions
                StudentDescription::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'aspect_id' => $aspect->id,
                        'semester' => $semester,
                    ],
                    ['final_text' => $finalText]
                );
            }
        }
    }

    // Halaman Edit/Preview Narasi setelah input nilai
    public function preview(Student $student)
    {
        $semester = request('semester', 1);
        $descriptions = StudentDescription::with('aspect')
            ->where('student_id', $student->id)
            ->where('semester', $semester)
            ->get();

        return view('scores.preview', compact('student', 'semester', 'descriptions'));
    }

    // Simpan hasil edit manual dari guru
    public function updatePreview(Request $request, Student $student)
    {
        $semester = $request->semester;

        foreach ($request->descriptions as $descId => $text) {
            StudentDescription::where('id', $descId)->update(['final_text' => $text]);
        }

        return redirect()->route('students.index')->with('success', 'Narasi final berhasil disimpan!');
    }

    // Menampilkan Preview Raport siap cetak per semester
    public function previewRaport(Student $student, $semester)
    {
        $descriptions = StudentDescription::with('aspect')
            ->where('student_id', $student->id)
            ->where('semester', $semester)
            ->get();

        return view('scores.raport_preview', compact('student', 'semester', 'descriptions'));
    }
}