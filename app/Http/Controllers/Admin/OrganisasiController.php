<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class OrganisasiController extends Controller
{
    public function index()
    {
        $organisasis = User::where('role', 'organisasi')
            ->latest()
            ->paginate(10);
        return view('admin.organisasi.index', compact('organisasis'));
    }

    public function create()
    {
        return view('admin.organisasi.create');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nama_organisasi' => 'required|string|max:255',
            'ketua_organisasi' => 'required|string|max:255',
            'jenis_organisasi' => 'required|in:UKM,BEM,Himpunan',
            'jumlah_anggota' => 'required|integer|min:1',
            'no_telp' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Siapkan data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nama_organisasi' => $request->nama_organisasi,
            'ketua_organisasi' => $request->ketua_organisasi,
            'jenis_organisasi' => $request->jenis_organisasi,
            'jumlah_anggota' => $request->jumlah_anggota,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'role' => 'organisasi'
        ];

        // Upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/organisasi');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);
            $data['foto'] = 'uploads/organisasi/' . $filename;
        }

        // Simpan ke database
        User::create($data);

        return redirect()->route('admin.organisasi.index')
            ->with('success', 'Organisasi berhasil ditambahkan!');
    }

    public function show(User $organisasi)
    {
        if ($organisasi->role !== 'organisasi') {
            return response()->json(['success' => false], 404);
        }

        // Perbaiki path foto untuk ditampilkan di modal
        $fotoUrl = null;
        if ($organisasi->foto && file_exists(public_path($organisasi->foto))) {
            $fotoUrl = asset($organisasi->foto);
        }

        return response()->json([
            'success' => true,
            'data' => $organisasi,
            'foto_url' => $fotoUrl
        ]);
    }

    public function edit(User $organisasi)
    {
        if ($organisasi->role !== 'organisasi') {
            return redirect()->route('admin.organisasi.index')->with('error', 'Data tidak valid');
        }
        return view('admin.organisasi.edit', compact('organisasi'));
    }

    public function update(Request $request, User $organisasi)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $organisasi->id,
            'nama_organisasi' => 'required|string|max:255',
            'ketua_organisasi' => 'required|string|max:255',
            'jenis_organisasi' => 'required|in:UKM,BEM,Himpunan',
            'jumlah_anggota' => 'required|integer|min:1',
            'no_telp' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nama_organisasi' => $request->nama_organisasi,
            'ketua_organisasi' => $request->ketua_organisasi,
            'jenis_organisasi' => $request->jenis_organisasi,
            'jumlah_anggota' => $request->jumlah_anggota,
            'no_telp' => $request->no_telp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

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

        $organisasi->update($data);

        return redirect()->route('admin.organisasi.index')
            ->with('success', 'Organisasi berhasil diupdate!');
    }

    public function destroy(User $organisasi)
    {
        if ($organisasi->foto && file_exists(public_path($organisasi->foto))) {
            unlink(public_path($organisasi->foto));
        }

        $organisasi->delete();
        return redirect()->route('admin.organisasi.index')
            ->with('success', 'Organisasi berhasil dihapus!');
    }
}





