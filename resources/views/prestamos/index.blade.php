<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Préstamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <!-- Encabezado con Botón de Solicitud -->
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('prestamos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                            + Solicitar Nuevo Préstamo
                        </a>
                    </div>
                </div>

                <!-- Mensaje de Éxito -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Tabla de Préstamos -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Equipo</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha Préstamo</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Devolución Esperada</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse ($prestamos as $prestamo)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $prestamo->equipo->nombre ?? 'Equipo no disponible' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $prestamo->user->name ?? 'Usuario desconocido' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-xs">{{ $prestamo->fecha_prestamo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-xs">{{ $prestamo->fecha_devolucion ?? 'Pendiente' }}</td>
                                    
                                    <!-- Badges de Estado con Colores Modernos -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $prestamo->estado == 'devuelto' || $prestamo->estado == 'Finalizado' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-yellow-100 text-yellow-800 border border-yellow-200' }}">
                                            <span class="w-2 h-2 mr-1.5 my-auto rounded-full 
                                                {{ $prestamo->estado == 'devuelto' || $prestamo->estado == 'Finalizado' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                            {{ ucfirst($prestamo->estado) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-sm">
                                        @if($prestamo->estado != 'devuelto' && $prestamo->estado != 'Finalizado')
                                            <!-- Aquí puedes colocar la ruta de registrar devolución si la tienes configurada -->
                                            <span class="text-indigo-600 hover:text-indigo-900 cursor-pointer font-semibold">Finalizar</span>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Completado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-6 text-center text-gray-500 italic">
                                        No hay registros de préstamos activos.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>