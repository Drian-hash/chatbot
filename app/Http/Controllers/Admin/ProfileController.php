<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        return view('admin.profile', compact('admin'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE (SECURE VERSION)
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $authAdmin = Auth::guard('admin')->user();

        if (!$authAdmin) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::findOrFail($authAdmin->id);

        $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO (AMAN + AUTO DELETE LAMA)
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada dan benar-benar ada di storage
            if ($admin->foto && Storage::disk('public')->exists($admin->foto)) {
                Storage::disk('public')->delete($admin->foto);
            }

            $file = $request->file('foto');

            // Nama unik (UUID)
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('admin', $fileName, 'public');

            $admin->foto = $filePath;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA
        |--------------------------------------------------------------------------
        */

        $admin->name  = trim($request->name);
        $admin->email = trim($request->email);

        if (!empty($request->password)) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
