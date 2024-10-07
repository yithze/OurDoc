<x-app-layout>
    @slot('title', 'Edit Folder')
    @if (session('success'))
    <script>
        alert("{{ session('success') }}");
        window.location.reload(); // Refresh halaman setelah alert ditutup
    </script>
    @endif


    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="text-gray-500 mr-3">Dashboard</a>
            >
            <a href="{{ route('folder') }}" class="ml-3 text-gray-500">Folder</a>
            >
            <a href="{{ route('folder.edit', $folder->id) }}" class="ml-3">Edit Folder</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Edit Folder
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Update Folder Name & Description
                        </p>
                    </header>

                    <form action="{{ route('folder.update', $folder->id) }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT') <!-- Method for updating -->

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $folder->name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>

                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <input id="description" name="description" type="text"
                                value="{{ old('description', $folder->description) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>

                        <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </form>

                    <div class="flex items-center gap-4 mt-4">
                        <!-- Delete Button -->
                        <form action="{{ route('folder.destroy', $folder->id) }}" method="POST">
                            @csrf
                            @method('DELETE') <!-- Method for deleting -->

                            <button type="submit" class="bg-red-500 text-white font-bold py-2 px-4 rounded"
                                onclick="return confirm('Are you sure you want to delete this folder?');">
                                Delete
                            </button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
