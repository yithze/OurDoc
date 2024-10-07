<x-app-layout>
    @slot('title', 'Search')
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
            <a href="{{ route('search') }}" class="ml-3">Search</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="flex flex-col md:flex-row gap-3">
                <div class="flex w-full">
                    <input type="text" id="search-input" placeholder="Search Document Name"
                        class="w-full px-3 h-15 rounded-l border-1 border-black focus:border-black focus:ring-0">
                    <button type="submit"
                        class="bg-black text-white rounded-r px-2 md:px-3 py-0 md:py-1">Search</button>
                </div>
                <select id="folder" name="folder"
                    class="w-full h-10 border-1 border-black focus:outline-none focus:border-black focus:ring-0 text-black rounded px-2 md:px-3 py-0 md:py-1 tracking-wider">
                    <option value="All" selected="">All Folder</option>
                    @foreach($folders as $folder)
                        <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                </select>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-11" id="entry-cards">
                <!-- Ini data entry -->
                @foreach($entries as $entry)
                <a href="{{ route('entry-data.edit', $entry->id) }}" class="block entry-card" data-folder="{{ json_decode($entry->folder)->id ?? 'N/A' }}" data-name="{{ $entry->name }}">
                    <x-doc>
                        <x-slot name="icon">
                            <x-heroicon-o-document class="w-12 h-12 text-white" />
                        </x-slot>

                        <x-doc-title title="{{ $entry->name }}">Name</x-doc-title>

                        @php
                        $folder = json_decode($entry->folder); // Deserialisasi folder
                        @endphp

                        <x-doc-description description="{{ $folder->name ?? 'N/A' }}">Folder</x-doc-description>
                        <x-doc-description description="{{ $entry->document_number }}">Doc Number</x-doc-description>
                        <x-doc-description description="{{ $entry->date }}">Date</x-doc-description>
                        <x-doc-description description="{{ $entry->document_storage }}">Storage</x-doc-description>
                        <x-doc-description description="Entry">From</x-doc-description>
                    </x-doc>
                </a>
                @endforeach

                <!-- Ini card custom field -->
                @foreach($customFields as $customfield)
                <a href="{{ route('custom-field.edit', $customfield->id) }}" class="block entry-card" data-folder="{{ json_decode($customfield->folder)->id ?? 'N/A' }}" data-name="{{ $customfield->name }}">
                    <x-doc>
                        <x-slot name="icon">
                            <x-heroicon-o-document class="w-12 h-12 text-white" />
                        </x-slot>

                        <x-doc-title title="{{ $customfield->name }}">Name</x-doc-title>

                        @php
                        $folder = json_decode($customfield->folder); // Deserialisasi folder untuk custom field
                        @endphp

                        <x-doc-description description="{{ $folder->name ?? 'N/A' }}">Folder</x-doc-description>
                        <x-doc-description description="{{ $customfield->document_number }}">Doc Number</x-doc-description>
                        <x-doc-description description="{{ $customfield->date }}">Date</x-doc-description>
                        <x-doc-description description="{{ $customfield->document_storage }}">Storage</x-doc-description>
                        <x-doc-description description="Custom Field">From</x-doc-description>
                    </x-doc>
                </a>
                @endforeach

                <!-- Ini card custom field -->
                @foreach($docApprovals as $docApproval)
                <a href="{{ route('doc-approval.edit', $docApproval->id) }}" class="block entry-card" data-folder="{{ json_decode($docApproval->folder)->id ?? 'N/A' }}" data-name="{{ $docApproval->name }}">
                    <x-doc>
                        <x-slot name="icon">
                            <x-heroicon-o-document class="w-12 h-12 text-white" />
                        </x-slot>

                        <x-doc-title title="{{ $docApproval->name }}">Name</x-doc-title>

                        @php
                        $folder = json_decode($docApproval->folder); // Deserialisasi folder untuk custom field
                        @endphp

                        <x-doc-description description="{{ $folder->name ?? 'N/A' }}">Folder</x-doc-description>
                        <x-doc-description description="{{ $docApproval->document_number }}">Doc Number</x-doc-description>
                        <x-doc-description description="{{ $docApproval->date }}">Date</x-doc-description>
                        <x-doc-description description="{{ $docApproval->document_storage }}">Storage</x-doc-description>
                        <x-doc-description description="Doc Approval">From</x-doc-description>
                    </x-doc>
                </a>
                @endforeach
            </div>
            <!-- end card -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const folderSelect = document.getElementById('folder');
            const entryCards = document.querySelectorAll('.entry-card');
            const searchInput = document.getElementById('search-input');

            folderSelect.addEventListener('change', function() {
                const selectedFolder = this.value;

                entryCards.forEach(card => {
                    const cardFolder = card.getAttribute('data-folder');

                    // Tampilkan atau sembunyikan card berdasarkan folder yang dipilih
                    if (selectedFolder === 'All' || cardFolder === selectedFolder) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                entryCards.forEach(card => {
                    const cardName = card.getAttribute('data-name').toLowerCase();

                    // Tampilkan atau sembunyikan card berdasarkan pencarian nama
                    if (cardName.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>

