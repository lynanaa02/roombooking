<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VisitorStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ==========================================
            // TAMBAH COUNT KUNJUNGAN DI DATABASE
            // ==========================================
            if (Auth::user()->role === 'admin') {
                $visitor = VisitorStat::where('user_id', Auth::id())->first();

                if (!$visitor) {
                    // Belum pernah ada data
                    VisitorStat::create([
                        'user_id' => Auth::id(),
                        'visit_count' => 1,
                        'first_visit' => Carbon::now('Asia/Jakarta'),
                        'last_visit' => Carbon::now('Asia/Jakarta'),
                    ]);
                } else {
                    // Sudah ada, tambah count
                    $visitor->increment('visit_count');
                    $visitor->update(['last_visit' => Carbon::now('Asia/Jakarta')]);
                }
            }

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('organisasi.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
