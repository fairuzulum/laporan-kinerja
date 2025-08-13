<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('unitKerja')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();
        return view('users.create', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:tim_sakip,unit_kerja,evaluator',
            'id_unit_fk' => 'nullable|exists:unit_kerjas,id_unit',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'id_unit_fk' => $validated['id_unit_fk'],
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $unitKerjas = UnitKerja::orderBy('nama_unit')->get();
        return view('users.edit', compact('user', 'unitKerjas'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => 'required|in:tim_sakip,unit_kerja,evaluator',
            'id_unit_fk' => 'nullable|exists:unit_kerjas,id_unit',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'id_unit_fk' => ($validated['role'] === 'unit_kerja') ? $validated['id_unit_fk'] : null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}