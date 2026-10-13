<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Rol de Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6 max-w-xl mx-auto">

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nombre del Usuario:</label>
                        <p class="mt-1 text-gray-900 font-semibold text-base">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Correo Electrónico:</label>
                        <p class="mt-1 text-gray-600 text-base">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label for="role" class="block font-medium text-sm text-gray-700 mb-1">Seleccionar Nuevo Rol:</label>
                        <select name="role" id="role" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 bg-white" required>
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student (Estudiante)</option>
                            <option value="encargado" {{ $user->role == 'encargado' ? 'selected' : '' }}>Encargado</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Administrador)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                            Guardar Cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>