<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AjaxSearchController extends Controller
{
    public function searchOrganisasi(Request $request)
    {
        try {
            $search = $request->get('search', '');
            $page = $request->get('page', 1);

            $query = User::where('role', 'organisasi'); //  role = 'organisasi'

            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_organisasi', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('ketua_organisasi', 'like', "%{$search}%");
                });
            }

            $organisasis = $query->latest()->paginate(10, ['*'], 'page', $page);

            // Render view
            $html = view('admin.organisasi._table_rows', compact('organisasis'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $organisasis->total(),
                'current_page' => $organisasis->currentPage(),
                'last_page' => $organisasis->lastPage(),
            ]);

        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchRuangan(Request $request)
    {
        try {
            $search = $request->get('search', '');

            $query = Ruangan::query();

            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_ruangan', 'like', "%{$search}%")
                      ->orWhere('kode_ruangan', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");
                });
            }

            $ruangans = $query->latest()->paginate(10);

            $html = view('admin.ruangan._table_rows', compact('ruangans'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $ruangans->total()
            ]);

        } catch (\Exception $e) {
            Log::error('Search Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
