<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitar Préstamo de Equipo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('prestamos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Buscador rápido en tiempo real para equipos -->
                    <div>
                        <label for="buscar_equipo" class="block font-medium text-sm text-gray-700 mb-1">Buscar Equipo Disponible:</label>
                        <input type="text" id="buscar_equipo" placeholder="Escribe para filtrar equipos..." class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
                    </div>

                    <!-- Selección de Equipo -->
                    <div>
                        <label for="equipo_id" class="block font-medium text-sm text-gray-700 mb-1">Seleccionar Equipo Disponible:</label>
                        <select name="equipo_id" id="equipo_id" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 bg-white" required>
                            <option value="">-- Selecciona un equipo --</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" data-name="{{ strtolower($equipo->nombre . ' ' . $equipo->codigo_inventario) }}">
                                    {{ $equipo->nombre }} (Código: {{ $equipo->codigo_inventario }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fecha y Hora de Devolución Esperada -->
                    <div>
                        <label for="fecha_devolucion_esperada" class="block font-medium text-sm text-gray-700 mb-1">Fecha y Hora de Devolución Esperada:</label>
                        <input type="datetime-local" name="fecha_devolucion_esperada" id="fecha_devolucion_esperada" value="{{ old('fecha_devolucion_esperada') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3" required>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('prestamos.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                            Registrar Préstamo
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Script JavaScript para filtrar las opciones del select en tiempo real -->
    <script>
        document.getElementById('buscar_equipo').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let select = document.getElementById('equipo_id');
            let options = select.options;

            for (let i = 1; i < options.length; i++) {
                let textData = options[i].getAttribute('data-name');
                if (textData.includes(filter)) {
                    options[i].style.display = '';
                } else {
                    options[i].style.display = 'none';
                }
            }
        });
    </script>
</x-app-layout>