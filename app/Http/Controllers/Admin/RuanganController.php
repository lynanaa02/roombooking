<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Ruangan::query();

        if ($search) {
            $query->where('nama_ruangan', 'like', "%{$search}%")
                ->orWhere('kode_ruangan', 'like', "%{$search}%")
                ->orWhere('lokasi', 'like', "%{$search}%");
        }

        $ruangans = $query->latest()->paginate(10);

        return view('admin.ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        return view('admin.ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|unique:ruangans',
            'lokasi' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,perbaikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:8192'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/ruangan');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);
            $data['foto'] = 'uploads/ruangan/' . $filename;
        }

        Ruangan::create($data);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    // TAMBAHKAN METHOD SHOW INI
    public function show(Ruangan $ruangan)
    {
        // Untuk detail ruangan (jika diperlukan)
        return view('admin.ruangan.show', compact('ruangan'));
    }

    // TAMBAHKAN METHOD GET DETAIL INI
    public function getDetail(Ruangan $ruangan)
    {
        return response()->json([
            'success' => true,
            'data' => $ruangan
        ]);
    }

    public function edit(Ruangan $ruangan)
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|unique:ruangans,kode_ruangan,' . $ruangan->id,
            'lokasi' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,perbaikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:8192'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($ruangan->foto && file_exists(public_path($ruangan->foto))) {
                unlink(public_path($ruangan->foto));
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/ruangan');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);
            $data['foto'] = 'uploads/ruangan/' . $filename;
        }

        $ruangan->update($data);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil diupdate!');
    }

    public function destroy(Ruangan $ruangan)
    {
        if ($ruangan->foto && file_exists(public_path($ruangan->foto))) {
            unlink(public_path($ruangan->foto));
        }

        $ruangan->delete();

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus!');
    }
}
