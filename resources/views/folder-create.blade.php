<x-app-layout>
    @slot('title', 'Dashboard')
    @if (session('success'))
    <script>
        alert("{{ session('success') }}");
        window.location.reload(); // Refresh halaman setelah alert ditutup
    </script>
    @endif


    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 leading-tight">
            <!-- {{ __('Dashboard > Folder') }} -->
            <a href="{{ route('dashboard') }}" class="text-gray-500 mr-3">Dashboard</a>
            >
            <a href="{{ route('folder') }}" class="ml-3 text-gray-500">Folder</a>
            >
            <a href="{{ route('folder-create') }}" class="ml-3">Create Folder</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Add Folder
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Add Folder Name & Description
                        </p>
                    </header>


                    <form action="{{ route('folder.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                            <input id="name" name="name" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>

                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <input id="description" name="description" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">
                                Save
                            </button>
                        </div>
                    </form>


                </section>
            </div>



        </div>
    </div>
</x-app-layout>
