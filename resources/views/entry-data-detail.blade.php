<x-app-layout>
    @slot('title', 'Edit Entry Data')
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
            <a href="{{ route('search') }}" class="text-gray-500 mr-3 ml-3">Search</a>
            >
            <a class="ml-3">Entry Data Detail</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mb-4 flex justify-between">
                    <div>
                        <button id="add-row" class="p-2 bg-black text-white rounded-md hover:bg-gray-800">
                            <x-heroicon-o-plus class="h-5 w-5" />
                        </button>
                        <button id="add-column" class="p-2 bg-black text-white rounded-md hover:bg-gray-800">
                            <x-heroicon-o-plus class="h-5 w-5 rotate-90" />
                        </button>
                        <button id="delete-row" class="p-2 bg-black text-white rounded-md hover:bg-gray-800">
                            <x-heroicon-o-trash class="h-5 w-5" />
                        </button>
                        <button id="delete-column" class="p-2 bg-black text-white rounded-md hover:bg-gray-800">
                            <x-heroicon-o-trash class="h-5 w-5 rotate-90" />
                        </button>
                    </div>
                    <div>
                        <button id="table-editor" class="p-2 bg-black text-white rounded-md hover:bg-gray-800">
                            TABLE EDITOR
                        </button>
                    </div>
                </div>
                <div id="table-container" class="overflow-x-auto">
                    <table class="min-w-full border-collapse table-auto">
                        <tbody>
                            <!-- Data rows will be filled dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-12">
                <form method="POST" action="{{ route('entry-data.update', $entry->id) }}" id="entry-form"
                    class="mt-6 space-y-6">
                    @csrf
                    @method('PUT') <!-- Method untuk update -->
                    <input type="hidden" name="from" value="entry data">

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $entry->name }}"
                            required />
                    </div>

                    <div>
                        <label for="folder" class="block font-medium text-sm text-gray-700">Folder</label>
                        <select id="folder" name="folder" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                            <option value="" disabled>Select a folder</option>
                            @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}" {{ $folder->id == $entry->folder_id ? 'selected' : '' }}>
                                {{ $folder->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="documentNumber" class="block font-medium text-sm text-gray-700">Document
                            Number</label>
                        <input id="documentNumber" name="documentNumber" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $entry->document_number }}" required />
                    </div>

                    <div>
                        <label for="date" class="block font-medium text-sm text-gray-700">Date</label>
                        <input id="date" name="date" type="date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $entry->date }}"
                            required />
                    </div>

                    <div>
                        <label for="documentStorage" class="block font-medium text-sm text-gray-700">Document
                            Storage</label>
                        <input id="documentStorage" name="documentStorage" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $entry->document_storage }}" required />
                    </div>

                    <!-- Input tersembunyi untuk data tabel -->
                    <input type="hidden" name="table_data" id="table_data_input">

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">
                            Save
                        </button>


                </form>
                <form action="{{ route('entry-data.destroy', $entry->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this entry?');">
                    @csrf
                    @method('DELETE') <!-- Method untuk delete -->
                    <button type="submit" id="delete-button" class="bg-red-600 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('Are you sure you want to delete this doc?');">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <style>
        /* Style for table input fields */
        #table-container input[type="text"] {
            width: 100%;
            border: none;
            outline: none;
            box-shadow: none;
            background-color: transparent;
            color: inherit;
        }

        /* Style for header cells */
        tr.bg-black td {
            background-color: black;
            /* Set background to black */
            color: white;
            /* Set text color to white */
            font-weight: bold;
            /* Make text bold for better visibility */
        }

        /* Style for table cells */
        td {
            border: 1px solid #ccc;
            padding: 8px;
            /* Add padding for better spacing */
        }

        /* Style for form input fields */
        input[type="text"] {
            width: 100%;
            border: 1px solid #ccc;
            outline: none;
            box-shadow: none;
            background-color: white;
            color: #000;
        }
    </style>

    <script>
        // Function to create cells
        function createCell(type, value = '') {
            const cell = document.createElement('td');
            const input = document.createElement('input');
            input.type = 'text';
            input.placeholder = 'Row Data';
            input.value = value; // Set value for editing
            input.className = 'w-full border-none rounded-md';

            cell.className = 'p-2 bg-white';
            cell.style.border = '1px solid #ccc';
            input.addEventListener('input', function () {
                adjustWidth(cell, input.value);
            });

            cell.appendChild(input);
            return cell;
        }

        function adjustWidth(cell, value) {
            const input = cell.querySelector('input');
            input.style.width = `${Math.max(input.scrollWidth, 50)}px`;
            cell.style.width = `${input.scrollWidth}px`;
        }

        function deleteLastRow() {
            const rows = document.querySelectorAll('tbody tr');
            if (rows.length > 0) {
                rows[rows.length - 1].remove(); // Remove the last row
            }
        }

        function deleteLastColumn() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const lastCell = row.lastElementChild;
                if (lastCell) {
                    lastCell.remove(); // Remove the last cell in each row
                }
            });
        }

        const tableBody = document.querySelector('tbody');

        const existingTableData = @json($existingTableData); // Existing table data

        if (Array.isArray(existingTableData) && existingTableData.length > 0) {
            existingTableData.forEach((rowData, index) => {
                const newRow = document.createElement('tr');

                // Check if this is the header row
                if (index === 0) {
                    newRow.className = 'bg-black text-white'; // Class for header
                }

                rowData.forEach(data => {
                    newRow.appendChild(createCell('data', data));
                });

                tableBody.appendChild(newRow);
            });
        }

        document.getElementById('add-row').addEventListener('click', function () {
            const newRow = document.createElement('tr');
            const cells = tableBody.querySelector('tr') ? tableBody.querySelector('tr').children.length : 1;
            for (let i = 0; i < cells; i++) {
                newRow.appendChild(createCell('data'));
            }
            tableBody.appendChild(newRow);
        });

        document.getElementById('add-column').addEventListener('click', function () {
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                row.appendChild(createCell('data'));
            });
        });

        document.getElementById('delete-row').addEventListener('click', deleteLastRow);
        document.getElementById('delete-column').addEventListener('click', deleteLastColumn);

        document.getElementById('entry-form').addEventListener('submit', function () {
            const rows = Array.from(document.querySelectorAll('tbody tr'));
            const tableData = rows.map(row => {
                return Array.from(row.querySelectorAll('input')).map(input => input.value);
            });

            document.getElementById('table_data_input').value = JSON.stringify(tableData);
        });
    </script>
</x-app-layout>
