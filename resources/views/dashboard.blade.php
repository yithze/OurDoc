<x-app-layout>
    @slot('title', 'Dashboard')

    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- card container -->
            <div class="flex flex-wrap justify-between gap-6">
                <!-- Kartu 1 -->
                <x-card onclick="window.location='{{ route('custom-field') }}'">
                    <div class="flex justify-between items-start">
                        <div class="flex w-full">
                            <x-card-icon>
                                <x-heroicon-o-document-plus class="w-6 h-6 text-white" />
                            </x-card-icon>
                            <x-card-title>Custom Field</x-card-title>
                        </div>
                        <button
                            class="p-1 text-gray-500 transition-colors rounded hover:bg-gray-100 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <x-card-description>Create Custom Field</x-card-description>
                </x-card>

                <!-- Kartu 2 -->
                <x-card onclick="window.location='{{ route('entry-data') }}'">
                    <div class="flex justify-between items-start">
                        <div class="flex w-full">
                            <x-card-icon>
                                <x-heroicon-o-document class="w-6 h-6 text-white" />
                            </x-card-icon>
                            <x-card-title>Entry Data</x-card-title>
                        </div>
                        <button
                            class="p-1 text-gray-500 transition-colors rounded hover:bg-gray-100 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <x-card-description>Create Entry Data</x-card-description>
                </x-card>

                <!-- Kartu 3 -->
                <x-card onclick="window.location='{{ route('doc-approval') }}'">
                    <div class="flex justify-between items-start">
                        <div class="flex w-full">
                            <x-card-icon>
                                <x-heroicon-o-document-check class="w-6 h-6 text-white" />
                            </x-card-icon>
                            <x-card-title>Doc Approval</x-card-title>
                        </div>
                        <button
                            class="p-1 text-gray-500 transition-colors rounded hover:bg-gray-100 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <x-card-description>Create Doc Approval.</x-card-description>
                </x-card>
                <!-- Kartu 4 -->
                <x-card onclick="window.location='{{ route('folder') }}'" class="cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="flex w-full">
                            <x-card-icon>
                                <x-heroicon-o-folder class="w-6 h-6 text-white" />
                            </x-card-icon>
                            <x-card-title>Folder</x-card-title>
                        </div>
                        <button
                            class="p-1 text-gray-500 transition-colors rounded hover:bg-gray-100 focus:outline-none">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" -->
                            <!--     stroke="currentColor"> -->
                            <!--     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" -->
                            <!--         d="M12 4v16m8-8H4" /> -->
                            <!-- </svg> -->
                        </button>
                    </div>
                    <x-card-description>Manage your Folder List</x-card-description>
                </x-card>
                <!-- Kartu 5 -->
                <x-card onclick="window.location='{{ route('search') }}'" class="cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="flex w-full">
                            <x-card-icon>
                                <x-heroicon-o-document-magnifying-glass class="w-6 h-6 text-white" />
                            </x-card-icon>
                            <x-card-title>Search</x-card-title>
                        </div>
                        <button
                            class="p-1 text-gray-500 transition-colors rounded hover:bg-gray-100 focus:outline-none">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" -->
                            <!--     stroke="currentColor"> -->
                            <!--     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" -->
                            <!--         d="M12 4v16m8-8H4" /> -->
                            <!-- </svg> -->
                        </button>
                    </div>
                    <x-card-description>Search Your Document </x-card-description>
                </x-card>

            </div>
            <!-- end card -->

        </div>
    </div>
</x-app-layout>
