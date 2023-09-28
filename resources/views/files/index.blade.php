


<x-app-layout>

<div class="container mx-auto pt-8 ">
    <h1 class="text-2xl font-semibold text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">Gerenciamento de Arquivos</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <h3 class="mt-4 text-xl font-semibold text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">Lista de Arquivos:</h3>
    <table class="w-full border-collapse border border-gray-400 mt-2">
        <thead>
            <tr>
                <th class="p-2 border border-gray-400 text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">Nome do Arquivo</th>
                <th class="p-2 border border-gray-400 text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr>
                <td class="p-2 border border-gray-400 text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">{{ $file }}</td>
                <td class="p-2 border border-gray-400">
                    <a href="{{ route('files.download', $file) }}" class="text-blue-600 hover:underline text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">Download</a>
                    <form action="{{ route('files.delete', $file) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mt-4 text-xl font-semibold text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">Enviar Arquivo:</h3>
    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
        @csrf
        <div class="mb-4">
            <input type="file" name="file" class="py-2 px-3 border border-gray-400 rounded w-full text-gray-500 dark:text-gray-400  focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700">
        </div>
        <button type="submit" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded">Enviar</button>
    </form>
</div>

    
</x-app-layout>
