<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 1) Cek user lokal dulu (khususnya admin dengan role = 1)
        $user = User::where('username', $request->username)->first();

        if ($user && intval($user->role) === 1) {
            // admiafarin langsung aktif (abaikan status)
            if (Hash::check($request->password, $user->password)) {
                session([
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'role' => $user->role,
                    ]
                ]);
                return redirect()->route('sk.index');
            }

            return back()->withErrors([
                'username' => 'Login gagal. Username atau password salah.',
            ]);
        }

        // 2) Kalau bukan admin lokal -> panggil API eksternal
        try {
            $response = Http::timeout(60)->post('https://port2.bsn.go.id/api/v1/User/Login', [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['success'])) {
                    // simpan / update user lokal (default role = 3 dan status = 0)
                    $userLocal = User::updateOrCreate(
                        ['username' => $data['success']['username']],
                        [
                            'name' => $data['success']['username'],
                            'password' => Hash::make($request->password),
                            'role' => $data['success']['role'] ?? 3,
                            'status' => 0, // default belum aktif
                        ]
                    );

                    // cek apakah user sudah aktif
                    if ($userLocal->status == 0) {
                        return back()->withErrors([
                            'username' => 'Akun Anda belum diaktifkan oleh admin.',
                        ]);
                    }

                    // simpan session
                    session([
                        'user' => [
                            'id' => $userLocal->id,
                            'username' => $userLocal->username,
                            'role' => $userLocal->role,
                        ],
                        'token' => $data['success']['token'] ?? null,
                    ]);

                    return redirect()->route('sk.index');
                }
            }

            return back()->withErrors([
                'username' => 'Login gagal. Username atau password salah.',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'username' => 'Terjadi kesalahan koneksi ke server eksternal: ' . $e->getMessage(),
            ]);
        }
    }


    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
