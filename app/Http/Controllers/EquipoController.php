<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipo::query();

        // Filtro de Búsqueda (por Nombre o Código de Inventario)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo_inventario', 'like', "%{$search}%");
            });
        }

        // Filtro por Estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Paginación (Muestra 6 equipos por página manteniendo los parámetros de búsqueda)
        $equipos = $query->latest()->paginate(6)->withQueryString();

        return view('equipos.index', compact('equipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acción no autorizada. Solo los administradores pueden registrar equipos.');
        }

        return view('equipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_inventario' => 'required|string|unique:equipos,codigo_inventario|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:disponible,prestado,mantenimiento',
        ]);

        Equipo::create($request->all());

        return redirect()->route('equipos.index')->with('success', 'Equipo registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $equipo = Equipo::findOrFail($id);
        return view('equipos.edit', compact('equipo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $equipo = Equipo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_inventario' => 'required|string|max:255|unique:equipos,codigo_inventario,' . $equipo->id,
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:disponible,prestado,mantenimiento',
        ]);

        $equipo->update($request->all());

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $equipo = Equipo::findOrFail($id);

        // Verificar si el equipo tiene un préstamo activo actualmente
        $prestamoActivo = Prestamo::where('equipo_id', $equipo->id)
            ->where('estado', 'prestado')
            ->with(['user', 'usuario'])
            ->first();

        if ($prestamoActivo) {
            $nombreEstudiante = optional($prestamoActivo->user)->name ?? (optional($prestamoActivo->usuario)->name ?? 'un estudiante');
            
            return redirect()->route('equipos.index')
                ->with('error', "No se puede eliminar el equipo porque se encuentra prestado a: {$nombreEstudiante}.");
        }

        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado exitosamente.');
    }
}