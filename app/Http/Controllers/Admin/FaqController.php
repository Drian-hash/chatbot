<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FaqImport;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::with('layanan');

        // 🔍 SEARCH
        if ($request->search) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        $faq = $query->orderBy('id', 'asc')->paginate(10);
        $layanan = Layanan::all();

        return view('admin.faq.index', compact('faq', 'layanan'));
    }

    // ➕ STORE
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string'
        ]);

        Faq::create([
            'layanan_id' => $request->layanan_id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan');
    }

    // ✏️ UPDATE
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string'
        ]);

        $faq->update([
            'layanan_id' => $request->layanan_id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diupdate');
    }

    // 🗑️ DELETE
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus');
    }

    // 📥 IMPORT
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,pdf|max:2048'
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        // 🔥 EXCEL / CSV
        if (in_array($extension, ['xlsx', 'xls', 'csv'])) {

            Excel::import(new FaqImport, $file);

            return redirect()->route('admin.faq.index')
                ->with('success', 'Data FAQ berhasil diimport dari Excel');
        }

        // 🔥 PDF (UPLOAD SAJA)
        if ($extension === 'pdf') {

            $file->store('uploads/pdf');

            return redirect()->route('admin.faq.index')
                ->with('success', 'File PDF berhasil diupload (belum diproses)');
        }

        return redirect()->back()->with('error', 'Format file tidak didukung');
    }
}
