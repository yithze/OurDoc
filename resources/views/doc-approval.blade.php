<x-app-layout>
    @slot('title', 'Doc Approval')
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
            <a href="{{ route('doc-approval') }}" class="ml-3">Doc Approval</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-14">
                <h3 class="text-lg font-medium text-gray-900">Upload File</h3>
                <form method="POST" action="{{ route('doc-approval.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="folder" class="block font-medium text-sm text-gray-700">Folder</label>
                        <select id="folder" name="folder" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="" disabled selected>Select a folder</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="documentNumber" class="block font-medium text-sm text-gray-700">Document Number</label>
                        <input id="documentNumber" name="documentNumber" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="date" class="block font-medium text-sm text-gray-700">Date</label>
                        <input id="date" name="date" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="documentStorage" class="block font-medium text-sm text-gray-700">Document Storage</label>
                        <input id="documentStorage" name="documentStorage" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <!-- Custom Add File Button -->
                    <div class="flex flex-col items-center justify-center mt-6">
                        <label id="upload-label" for="file-upload" class="w-full cursor-pointer flex flex-col items-center bg-gray-200 border border-dashed border-gray-400 rounded-lg p-6 hover:bg-gray-300 transition-all">
                            <svg id="upload-icon" class="w-12 h-12 text-gray-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span id="upload-text" class="text-gray-700 font-medium">Add File</span>
                            <input type="file" id="file-upload" name="file" accept="application/pdf, image/*" class="hidden" required onchange="previewFile()" />
                        </label>
                    </div>

                    <div id="file-preview" class="mt-4"></div> <!-- Preview area for the uploaded file -->

                    <!-- Approval Section -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Approvals</h4>
                        <div id="approvals-container">
                            <div class="approval-row flex gap-4 mb-4">
                                <div>
                                    <label for="approval_title" class="block font-medium text-sm text-gray-700">Approval Title</label>
                                    <input name="approvals[0][approval_title]" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                                </div>
                                <div>
                                    <label for="approval_by" class="block font-medium text-sm text-gray-700">Approval By</label>
                                    <input name="approvals[0][approval_by]" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                                </div>
                                <div>
                                    <label for="approval_date" class="block font-medium text-sm text-gray-700">Approval Date</label>
                                    <input name="approvals[0][approval_date]" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                                </div>
                                <button type="button" class="remove-row text-red-500">Remove</button>
                            </div>
                        </div>
                        <button type="button" id="add-approval" class="mt-2 bg-gray-700 text-white font-bold py-2 px-4 rounded">Add Approval</button>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let approvalCount = 1; // Counter for approval rows

        // Function to add a new approval row
        function addApprovalRow() {
            const approvalsContainer = document.getElementById('approvals-container');
            const newRow = document.createElement('div');
            newRow.classList.add('approval-row', 'flex', 'gap-4', 'mb-4');
            newRow.innerHTML = `
                <div>
                    <label for="approval_title" class="block font-medium text-sm text-gray-700">Approval Title</label>
                    <input name="approvals[${approvalCount}][approval_title]" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label for="approval_by" class="block font-medium text-sm text-gray-700">Approval By</label>
                    <input name="approvals[${approvalCount}][approval_by]" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label for="approval_date" class="block font-medium text-sm text-gray-700">Approval Date</label>
                    <input name="approvals[${approvalCount}][approval_date]" type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <button type="button" class="remove-row text-red-500">Remove</button>
            `;
            approvalsContainer.appendChild(newRow);
            approvalCount++;

            // Add event listener for the remove button
            newRow.querySelector('.remove-row').addEventListener('click', function () {
                if (approvalCount > 1) {
                    newRow.remove();
                    approvalCount--;
                }
            });
        }

        // Add approval row on button click
        document.getElementById('add-approval').addEventListener('click', addApprovalRow);

        // Add event listener for the first remove button
        document.querySelectorAll('.remove-row').forEach(button => {
            button.addEventListener('click', function (e) {
                if (approvalCount > 1) {
                    e.target.closest('.approval-row').remove();
                    approvalCount--;
                }
            });
        });
    });

    function previewFile() {
        const fileInput = document.getElementById('file-upload');
        const file = fileInput.files[0];
        const preview = document.getElementById('file-preview');
        const uploadLabel = document.getElementById('upload-label');
        const uploadText = document.getElementById('upload-text');
        const uploadIcon = document.getElementById('upload-icon');

        // Clear previous preview
        preview.innerHTML = '';

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('mt-4', 'w-full', 'h-auto');
                    preview.appendChild(img);
                } else if (file.type === 'application/pdf') {
                    const embed = document.createElement('embed');
                    embed.src = e.target.result;
                    embed.type = 'application/pdf';
                    embed.width = '100%';
                    embed.height = '500px';
                    preview.appendChild(embed);
                }

                // Update the upload label text to show the file name
                uploadText.textContent = file.name;
                uploadIcon.style.display = 'none'; // Hide the icon after file selection
            };
            reader.readAsDataURL(file);
        }
    }
</script>

