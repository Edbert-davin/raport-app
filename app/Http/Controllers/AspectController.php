<?php
namespace App\Http\Controllers;

use App\Models\Aspect;
use App\Models\SubIndicator;
use Illuminate\Http\Request;

class AspectController extends Controller
{
    // Tampilkan semua Mata Pelajaran beserta Sub-Indikatornya
    public function index()
    {
        $aspects = Aspect::with('subIndicators')->get();
        return view('aspects.index', compact('aspects'));
    }

    // Simpan Mata Pelajaran (Aspek) baru
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Aspect::create(['name' => $request->name]);
        
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    // Hapus Mata Pelajaran
    public function destroy(Aspect $aspect)
    {
        $aspect->delete(); // Otomatis menghapus sub-indikator karena cascade di database
        return back()->with('success', 'Mata Pelajaran berhasil dihapus.');
    }

    // Simpan Sub-Indikator (Topik/Kompetensi Dasar) baru
    public function storeSubIndicator(Request $request, Aspect $aspect)
    {
        $request->validate(['description' => 'required|string|max:255']);
        $aspect->subIndicators()->create(['description' => $request->description]);
        
        return back()->with('success', 'Sub-indikator berhasil ditambahkan.');
    }

    // Hapus Sub-Indikator
    public function destroySubIndicator(SubIndicator $subIndicator)
    {
        $subIndicator->delete();
        return back()->with('success', 'Sub-indikator berhasil dihapus.');
    }
}