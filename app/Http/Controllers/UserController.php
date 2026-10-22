<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Validar que solo el administrador pueda entrar
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $query = User::query();

        // Buscador por nombre o correo
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(6)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $request->validate([
            'role' => 'required|in:admin,encargado,estudiante',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Rol de usuario actualizado correctamente.');
    }
}