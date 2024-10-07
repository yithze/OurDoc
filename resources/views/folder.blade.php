<x-app-layout>
    @slot('title', 'Dashboard')

    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}" class="text-gray-500 mr-3">Dashboard</a>
            >
            <a href="{{ route('folder') }}" class="ml-3">Folder</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="flex flex-col md:flex-row gap-3">
                <div class="flex w-full">
                    <input type="text" placeholder="Search here..."
                        class="w-full px-3 h-15 rounded-l border-1 border-black focus:border-black focus:ring-0">
                    <button type="submit"
                        class="bg-black text-white rounded-r px-2 md:px-3 py-0 md:py-1">Search</button>
                    <button type="button" class="bg-black text-white rounded px-2 md:px-3 py-0 md:py-1 ml-3 w-20"
                        onclick="window.location='{{ route('folder-create') }}'">
                        Add
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-11">
                @foreach ($folders as $folder) <!-- Loop through folder data -->
                    <a href="{{ route('folder.edit', $folder->id) }}" class="block"> <!-- Wrap with link to edit -->
                        <x-doc>
                            <x-slot name="icon">
                                <x-heroicon-o-folder class="w-12 h-12 text-white" />
                            </x-slot>

                            <x-doc-title title="{{ $folder->name }}">Name</x-doc-title>
                            <x-doc-description description="{{ $folder->description }}">Desc</x-doc-description>
                            <!-- <x-doc-description description="0">Count</x-doc-description> -->
                        </x-doc>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

