<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h3 class="text-lg font-medium text-gray-900">Lista de Usuarios Registrados</h3>

                    <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o correo..." class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-1.5 px-3 w-64">
                        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition">
                            Buscar
                        </button>
                        @if(request('search'))
                            <a href="{{ route('users.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 underline font-medium">Limpiar</a>
                        @endif
                    </form>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rol Actual</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach ($users as $usuario)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $usuario->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $usuario->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $usuario->role == 'admin' ? 'bg-purple-100 text-purple-800 border border-purple-200' : '' }}
                                            {{ $usuario->role == 'encargado' ? 'bg-blue-100 text-blue-800 border border-blue-200' : '' }}
                                            {{ $usuario->role == 'student' ? 'bg-gray-100 text-gray-800 border border-gray-200' : '' }}">
                                            {{ $usuario->role == 'admin' ? 'Encargado' : ucfirst($usuario->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        <a href="{{ route('users.edit', $usuario->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Editar Rol</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>