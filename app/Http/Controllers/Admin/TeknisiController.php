<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeknisiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $teknisis = User::where('role', 'teknisi')
            ->when($search, function ($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10);
            
        return view('admin.teknisi.index', compact('teknisis', 'search'));
    }

    public function create()
    {
        return view('admin.teknisi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'teknisi';

        User::create($validated);

        return redirect()->route('admin.teknisi.index')->with('success', 'Akun teknisi berhasil ditambahkan.');
    }

    public function edit(User $teknisi)
    {
        if ($teknisi->role !== 'teknisi') {
            abort(404);
        }
        return view('admin.teknisi.edit', compact('teknisi'));
    }

    public function update(Request $request, User $teknisi)
    {
        if ($teknisi->role !== 'teknisi') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $teknisi->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $teknisi->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if (filled($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $teknisi->update($validated);

        return redirect()->route('admin.teknisi.index')->with('success', 'Akun teknisi berhasil diperbarui.');
    }

    public function destroy(User $teknisi)
    {
        if ($teknisi->role !== 'teknisi') {
            abort(404);
        }

        if ($teknisi->diagnosas()->exists()) {
            return back()->with('error', 'Teknisi tidak bisa dihapus karena memiliki riwayat diagnosa.');
        }

        $teknisi->delete();

        return redirect()->route('admin.teknisi.index')->with('success', 'Akun teknisi berhasil dihapus.');
    }
}
