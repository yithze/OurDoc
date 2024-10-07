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
            <a href="{{ route('dashboard') }}" class="text-gray-500 mr-3">Dashboard</a>
            >
            <a href="{{ route('entry-data') }}" class="ml-3">Entry Data</a>
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
                        <button class="p-2 bg-black text-white rounded-md hover:bg-gray-800">
                            TABLE EDITOR
                        </button>
                    </div>
                </div>

                <div id="table-container" class="overflow-x-auto">
                    <table class="min-w-full border-collapse table-auto">
                        <tbody>
                            <!-- Data rows will be inserted here -->
                        </tbody>
                    </table>
                </div>
                <h6 class="mt-4">
                    First Row Is Header
                </h6>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-12">
                <form method="POST" action="{{ route('entry-data.store') }}" id="entry-form" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="from" value="entry data">

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="folder" class="block font-medium text-sm text-gray-700">Folder</label>
                        <select id="folder" name="folder" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                            <option value="" disabled>Select a folder</option>
                            @foreach ($folders as $folder)
                            <option value="{{ $folder->id }}">
                                {{ $folder->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="documentNumber" class="block font-medium text-sm text-gray-700">Document
                            Number</label>
                        <input id="documentNumber" name="documentNumber" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="date" class="block font-medium text-sm text-gray-700">Date</label>
                        <input id="date" name="date" type="date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="documentStorage" class="block font-medium text-sm text-gray-700">Document
                            Storage</label>
                        <input id="documentStorage" name="documentStorage" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <input type="hidden" name="table_data" id="table_data_input">

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">
                            Save
                        </button>
                    </div>
                </form>
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

        /* Style for table body cells */
        td {
            border: 1px solid #ccc;
        }

        /* Style for table body input */
        td input[type="text"] {
            background-color: #fff;
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

        /* Add this class for bold text */
        .font-bold {
            font-weight: bold;
        }
    </style>

    <script>
        // Function to create data cells
        function createCell(type) {
            const cell = document.createElement('td');
            const input = document.createElement('input');
            input.type = 'text';
            input.placeholder = '';
            input.className = 'w-full border-none rounded-md';
            input.addEventListener('input', function () {
                adjustWidth(cell, input.value);
            });

            cell.className = `p-2 bg-white`;
            cell.style.border = '1px solid #ccc';
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
                rows[rows.length - 1].remove();
            }
        }

        function deleteLastColumn() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const lastCell = row.lastElementChild;
                if (lastCell) {
                    lastCell.remove();
                }
            });
        }

        const tableBody = document.querySelector('tbody');

        // Add row functionality
        document.getElementById('add-row').addEventListener('click', function () {
            const newRow = document.createElement('tr');
            const columnCount = tableBody.querySelector('tr') ? tableBody.querySelector('tr').children.length : 0;

            // Check if this is the first row
            const isFirstRow = tableBody.children.length === 0;

            for (let i = 0; i < columnCount || i === 0; i++) {
                const cell = createCell('data');

                // If it's the first row, add a bold class
                if (isFirstRow) {
                    cell.classList.add('font-bold'); // Add this class for bold text
                }

                newRow.appendChild(cell);
            }
            tableBody.appendChild(newRow);
        });

        // Add column functionality
        document.getElementById('add-column').addEventListener('click', function () {
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                const cell = createCell('data');

                // If the row is the first one, add the bold class
                if (row === rows[0]) {
                    cell.classList.add('font-bold'); // Ensure the first row has bold cells
                }

                row.appendChild(cell);
            });
        });

        // Delete last row functionality
        document.getElementById('delete-row').addEventListener('click', deleteLastRow);

        // Delete last column functionality
        document.getElementById('delete-column').addEventListener('click', deleteLastColumn);

        document.getElementById('entry-form').addEventListener('submit', function () {
            const tableData = [];
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const rowData = [];
                const cells = row.querySelectorAll('td input[type="text"]');
                cells.forEach(cell => {
                    rowData.push(cell.value);
                });
                tableData.push(rowData);
            });

            document.getElementById('table_data_input').value = JSON.stringify(tableData);
        });
    </script>
</x-app-layout>
