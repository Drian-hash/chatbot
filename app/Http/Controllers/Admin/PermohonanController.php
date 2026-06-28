<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Layanan;

class PermohonanController extends Controller
{
    /**
     * =====================================
     * DAFTAR PERMOHONAN
     * =====================================
     */
    public function index(Request $request)
    {
        $query = Permohonan::with([
            'user',
            'layanan'
        ]);

        // ==========================
        // SEARCH
        // ==========================

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('kode_permohonan', 'like', "%{$search}%")
                    ->orWhere('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('nomor_hp', 'like', "%{$search}%");

            });
        }

        // ==========================
        // FILTER LAYANAN
        // ==========================

        if ($request->filled('layanan')) {

            $query->where('layanan_id', $request->layanan);

        }

        // ==========================
        // FILTER STATUS
        // ==========================

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        $permohonans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $layanans = Layanan::orderBy('nama_layanan')->get();

        return view(
            'admin.permohonan.index',
            compact(
                'permohonans',
                'layanans'
            )
        );
    }

    /**
     * =====================================
     * DETAIL (AJAX MODAL)
     * =====================================
     */
    public function show($id)
    {
        $permohonan = Permohonan::with([
            'user',
            'layanan',
            'admin'
        ])->findOrFail($id);

        return response()->json($permohonan);
    }

    /**
     * =====================================
     * UPDATE STATUS
     * =====================================
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'status' => 'required',

            'catatan_admin' => 'nullable'

        ]);

        $permohonan = Permohonan::findOrFail($id);

        $permohonan->update([

            'status' => $request->status,

            'catatan_admin' => $request->catatan_admin,

            'admin_id' => auth('admin')->id(),

            'tanggal_selesai' => $request->status == 'Selesai'
                ? now()
                : null

        ]);

        return redirect()
            ->back()
            ->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * =====================================
     * HAPUS
     * =====================================
     */
    public function destroy($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        $permohonan->delete();

        return response()->json([

            'success' => true,

            'message' => 'Permohonan berhasil dihapus.'

        ]);
    }
}
