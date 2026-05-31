<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman profil utama.
     */
    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Form edit profil.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Simpan perubahan profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9._]+$/',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'address' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.regex' => 'Username hanya boleh huruf, angka, titik, dan garis bawah.',
            'username.unique' => 'Username sudah digunakan.',
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'avatar.image' => 'Foto harus berupa file gambar.',
            'avatar.mimes' => 'Foto harus berformat JPEG, PNG, GIF, atau WEBP.',
            'avatar.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('profile.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        unset($data['avatar']);
        $data['username'] = ltrim($data['username'], '@');

        if ($request->hasFile('avatar')) {
            $this->deleteAvatar($user->avatar);
            $data['avatar'] = $this->storeAvatar($request);
        }

        $user->update($data);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Form ubah password.
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * Simpan password baru.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('profile.password')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()
                ->route('profile.password')
                ->withErrors(['current_password' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Password berhasil diubah.');
    }

    /**
     * Simpan foto profil ke public/image/profile.
     */
    private function storeAvatar(Request $request): string
    {
        $file = $request->file('avatar');
        $directory = public_path('image/profile');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename .= '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'image/profile/' . $filename;
    }

    /**
     * Hapus file avatar lama jika ada.
     */
    private function deleteAvatar(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = public_path($path);

        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}
