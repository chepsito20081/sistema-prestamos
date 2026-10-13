<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Principal - Sistema de Préstamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Tarjetas de Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-indigo-500 transition hover:shadow-md duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Equipos</div>
                            <div class="text-3xl font-extrabold text-gray-800 mt-1">{{ \App\Models\Equipo::count() }}</div>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-green-500 transition hover:shadow-md duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Disponibles</div>
                            <div class="text-3xl font-extrabold text-gray-800 mt-1">{{ \App\Models\Equipo::where('estado', 'disponible')->count() }}</div>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-yellow-500 transition hover:shadow-md duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Préstamos Activos</div>
                            <div class="text-3xl font-extrabold text-gray-800 mt-1">{{ \App\Models\Prestamo::where('estado', 'activo')->count() }}</div>
                        </div>
                        <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-blue-500 transition hover:shadow-md duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Usuarios</div>
                            <div class="text-3xl font-extrabold text-gray-800 mt-1">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tabla de Actividad Reciente -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Últimos Préstamos Registrados</h3>
                    <a href="{{ route('prestamos.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 uppercase">Ver todos →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b text-xs font-semibold text-gray-500 uppercase bg-gray-50">
                                <th class="py-3 px-4">Equipo</th>
                                <th class="py-3 px-4">Solicitante</th>
                                <th class="py-3 px-4">Fecha Préstamo</th>
                                <th class="py-3 px-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse(\App\Models\Prestamo::with(['equipo', 'user'])->latest()->take(5)->get() as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $p->equipo->nombre ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $p->user->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-gray-500">{{ \Carbon\Carbon::parse($p->fecha_prestamo)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full {{ $p->estado == 'activo' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($p->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-400 italic">No hay préstamos registrados aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>