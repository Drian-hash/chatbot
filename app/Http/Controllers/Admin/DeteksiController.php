<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IkasandiPertanyaan;
use App\Models\IkasandiKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class DeteksiController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | DETEKSI USER UPDATE
    |--------------------------------------------------------------------------
    */

    private function getUpdater()
    {
        if (Auth::guard('admin')->check()) {
            return [
                'id' => Auth::guard('admin')->id(),
                'type' => 'admin'
            ];
        }

        return [
            'id' => Auth::guard('web')->id(),
            'type' => 'user'
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        $kategoriList = IkasandiKategori::where('is_active', true)
            ->where(function ($q) {
                $q->where('kode_kategori', '3')
                  ->orWhere('kode_kategori', 'like', '3.%');
            })
            ->orderByRaw("
                CAST(SUBSTRING_INDEX(kode_kategori,'.',1) AS UNSIGNED),
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode_kategori,'.',2),'.',-1) AS UNSIGNED),
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode_kategori,'.',3),'.',-1) AS UNSIGNED)
            ")
            ->get();

        $kodeKategori = $request->kategori ?? $kategoriList->first()?->kode_kategori;
        $search = $request->search;

        $kategori = IkasandiKategori::where('kode_kategori', $kodeKategori)->first();

        $soal = collect();

        if ($kategori) {

            $soal = IkasandiPertanyaan::deteksi()

                ->where('kategori_id', $kategori->id)

                ->when($search, function ($query) use ($search) {

                    $query->where(function ($q) use ($search) {

                        $q->where('kode_soal', 'like', "%$search%")
                          ->orWhere('pertanyaan', 'like', "%$search%");

                    });

                })

                ->orderByRaw("LENGTH(kode_soal), kode_soal")

                ->get()

                ->map(function ($item) {

                    $item->bukti_url = $item->bukti_dukung
                        ? asset('storage/' . $item->bukti_dukung)
                        : null;

                    $item->bukti_extension = $item->bukti_dukung
                        ? strtolower(pathinfo($item->bukti_dukung, PATHINFO_EXTENSION))
                        : null;

                    return $item;

                });
        }

        return view(
            'admin.ikasandi.deteksi.index',
            compact('soal', 'kategoriList', 'kodeKategori', 'kategori', 'search')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([
            'kategori_id' => 'required|exists:ikasandi_kategori,id',
            'kode_soal' => 'required',
            'pertanyaan' => 'required',
            'nilai' => 'required|integer|min:0|max:5',
            'bukti_dukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $filePath = null;

        if ($request->hasFile('bukti_dukung')) {

            $file = $request->file('bukti_dukung');

            $fileName = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();

            $filePath = $file->storeAs(
                'ikasandi/deteksi',
                $fileName,
                'public'
            );
        }

        $updater = $this->getUpdater();

        IkasandiPertanyaan::create([
            'domain' => 'deteksi',
            'kategori_id' => $request->kategori_id,
            'kode_soal' => $request->kode_soal,
            'pertanyaan' => $request->pertanyaan,
            'nilai' => $request->nilai,
            'bukti_dukung' => $filePath,
            'updated_by' => $updater['id'],
            'updated_type' => $updater['type']
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan');
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, IkasandiPertanyaan $deteksi)
    {

        if ($deteksi->domain !== 'deteksi') {
            abort(404);
        }

        $request->validate([
            'kode_soal' => 'required',
            'pertanyaan' => 'required',
            'nilai' => 'required|integer|min:0|max:5',
            'bukti_dukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('bukti_dukung')) {

            if (
                $deteksi->bukti_dukung &&
                Storage::disk('public')->exists($deteksi->bukti_dukung)
            ) {
                Storage::disk('public')->delete($deteksi->bukti_dukung);
            }

            $file = $request->file('bukti_dukung');

            $fileName = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();

            $deteksi->bukti_dukung = $file->storeAs(
                'ikasandi/deteksi',
                $fileName,
                'public'
            );
        }

        $updater = $this->getUpdater();

        $deteksi->update([
            'kode_soal' => $request->kode_soal,
            'pertanyaan' => $request->pertanyaan,
            'nilai' => $request->nilai,
            'updated_by' => $updater['id'],
            'updated_type' => $updater['type']
        ]);

        return back()->with('success', 'Soal berhasil diperbarui');
    }


    /*
    |--------------------------------------------------------------------------
    | UPLOAD BUKTI
    |--------------------------------------------------------------------------
    */

    public function uploadBukti(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:ikasandi_pertanyaan,id',
            'bukti_dukung' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $soal = IkasandiPertanyaan::deteksi()->findOrFail($request->id);

        if ($request->hasFile('bukti_dukung')) {

            if (
                $soal->bukti_dukung &&
                Storage::disk('public')->exists($soal->bukti_dukung)
            ) {
                Storage::disk('public')->delete($soal->bukti_dukung);
            }

            $file = $request->file('bukti_dukung');

            $fileName = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();

            $filePath = $file->storeAs(
                'ikasandi/deteksi',
                $fileName,
                'public'
            );

            $updater = $this->getUpdater();

            $soal->update([
                'bukti_dukung' => $filePath,
                'updated_by' => $updater['id'],
                'updated_type' => $updater['type']
            ]);
        }

        return back()->with('success', 'Bukti dukung berhasil diupload');
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(IkasandiPertanyaan $deteksi)
    {

        if ($deteksi->domain !== 'deteksi') {
            abort(404);
        }

        if (
            $deteksi->bukti_dukung &&
            Storage::disk('public')->exists($deteksi->bukti_dukung)
        ) {
            Storage::disk('public')->delete($deteksi->bukti_dukung);
        }

        $deteksi->delete();

        return back()->with('success', 'Soal berhasil dihapus');
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE NILAI REALTIME
    |--------------------------------------------------------------------------
    */

    public function updateNilai(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:ikasandi_pertanyaan,id',
            'nilai' => 'required|integer|min:0|max:5'
        ]);

        $soal = IkasandiPertanyaan::deteksi()->findOrFail($request->id);

        $updater = $this->getUpdater();

        $soal->update([
            'nilai' => $request->nilai,
            'updated_by' => $updater['id'],
            'updated_type' => $updater['type']
        ]);

        $user = Auth::guard('admin')->check()
            ? Auth::guard('admin')->user()
            : Auth::guard('web')->user();

        return response()->json([
            'success' => true,
            'user' => $user->name,
            'tanggal' => now()->format('d-m-Y H:i')
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS BUKTI
    |--------------------------------------------------------------------------
    */

    public function hapusBukti($id)
    {

        $soal = IkasandiPertanyaan::deteksi()->findOrFail($id);

        if (
            $soal->bukti_dukung &&
            Storage::disk('public')->exists($soal->bukti_dukung)
        ) {
            Storage::disk('public')->delete($soal->bukti_dukung);
        }

        $soal->update([
            'bukti_dukung' => null
        ]);

        return back()->with('success', 'Bukti berhasil dihapus');
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        $collection = Excel::toCollection(null, $request->file('file_excel'));

        DB::beginTransaction();

        try {

            $updater = $this->getUpdater();

            foreach ($collection[0] as $index => $row) {

                if ($index == 0) continue;

                if (empty($row[0]) && empty($row[1]) && empty($row[2])) continue;

                $kodeKategori = trim($row[0] ?? '');
                $kodeSoal = trim($row[1] ?? '');
                $pertanyaan = trim($row[2] ?? '');
                $nilai = $row[3] ?? 0;

                if (!$kodeKategori || !$kodeSoal || !$pertanyaan) continue;

                /* FILTER DOMAIN 3 */

                if (!Str::startsWith($kodeKategori, '3')) {
                    continue;
                }

                $kategori = IkasandiKategori::where('kode_kategori', $kodeKategori)->first();

                if (!$kategori) continue;

                $nilai = ($nilai < 0 || $nilai > 5) ? 0 : $nilai;

                IkasandiPertanyaan::updateOrCreate(

                    [
                        'domain' => 'deteksi',
                        'kode_soal' => $kodeSoal
                    ],

                    [
                        'kategori_id' => $kategori->id,
                        'pertanyaan' => $pertanyaan,
                        'nilai' => $nilai,
                        'updated_by' => $updater['id'],
                        'updated_type' => $updater['type']
                    ]

                );
            }

            DB::commit();

            return back()->with('success', 'Import berhasil');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Import gagal : '.$e->getMessage());

        }
    }
}
