<?php

namespace App\Http\Controllers\Organisasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //  * Tampilkan halaman profile organisasi
    public function index()
    {
        $organisasi = Auth::user();
        return view('organisasi.profile', compact('organisasi'));
    }

    //  * Update profil organisasi
    public function update(Request $request)
    {
        $organisasi = Auth::user();

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'nama_organisasi' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $organisasi->id,
            'ketua_organisasi' => 'required|string|max:255',
            'jumlah_anggota' => 'required|integer|min:1',
            'no_telp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Data yang akan diupdate
        $data = [
            'name' => $request->name,
            'nama_organisasi' => $request->nama_organisasi,
            'email' => $request->email,
            'ketua_organisasi' => $request->ketua_organisasi,
            'jumlah_anggota' => $request->jumlah_anggota,
            'no_telp' => $request->no_telp,
        ];

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($organisasi->foto && file_exists(public_path($organisasi->foto))) {
                unlink(public_path($organisasi->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/organisasi');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);
            $data['foto'] = 'uploads/organisasi/' . $filename;
        }

        // Update data
        $organisasi->update($data);

        return redirect()->route('organisasi.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    //  * Update password organisasi
    public function updatePassword(Request $request)
    {
        $organisasi = Auth::user();

        // Validasi
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, $organisasi->password)) {
            return redirect()->route('organisasi.profile')
                ->with('error', 'Password lama tidak sesuai!')
                ->with('tab', 'password'); // Kirim parameter tab
        }

        // Update password
        $organisasi->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('organisasi.profile')
            ->with('success', 'Password berhasil diubah! Silakan login kembali.')
            ->with('tab', 'password');
    }
}
