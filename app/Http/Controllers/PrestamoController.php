<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Si es admin/encargado ve todos, si es estudiante ve solo los suyos
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'encargado') {
            $query = Prestamo::with(['equipo', 'user']);
        } else {
            $query = Prestamo::with(['equipo', 'user'])->where('user_id', Auth::id());
        }

        // Filtro de Búsqueda (por nombre/código de equipo o nombre de usuario)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('equipo', function($subq) use ($search) {
                    $subq->where('nombre', 'like', "%{$search}%")
                          ->orWhere('codigo_inventario', 'like', "%{$search}%");
                })->orWhereHas('user', function($subq) use ($search) {
                    $subq->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Filtro por Estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Paginación (6 por página manteniendo los parámetros de búsqueda)
        $prestamos = $query->latest()->paginate(6)->withQueryString();

        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Solo mostramos equipos que estén disponibles
        $equipos = Equipo::where('estado', 'disponible')->get();
        return view('prestamos.create', compact('equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'fecha_devolucion_esperada' => 'required|date|after:today',
        ]);

        // Crear el préstamo
        Prestamo::create([
            'equipo_id' => $request->equipo_id,
            'user_id' => Auth::id(),
            'fecha_prestamo' => Carbon::now(),
            'fecha_devolucion_esperada' => $request->fecha_devolucion_esperada,
            'estado' => 'activo',
        ]);

        // Cambiar el estado del equipo a 'prestado'
        $equipo = Equipo::find($request->equipo_id);
        $equipo->update(['estado' => 'prestado']);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado exitosamente.');
    }

    /**
     * Marcar un préstamo como devuelto.
     */
    public function devolver($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        // Actualizar el préstamo
        $prestamo->update([
            'fecha_devolucion_real' => Carbon::now(),
            'estado' => 'devuelto',
        ]);

        // Liberar el equipo nuevamente
        $prestamo->equipo->update(['estado' => 'disponible']);

        return redirect()->route('prestamos.index')->with('success', 'Equipo devuelto correctamente.');
    }
}