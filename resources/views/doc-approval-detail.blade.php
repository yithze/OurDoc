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
            <a href="{{ route('search') }}" class="text-gray-500 mr-3 ml-3">Search</a>
            >
            <a class="ml-3">Doc Approval Detail</a>

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-14">
                <h3 class="text-lg font-medium text-gray-900">Edit Doc Approval</h3>
                <form method="POST" action="{{ route('doc-approval.update', $docApproval->id) }}"
                    enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $docApproval->name }}" required />
                    </div>

                    <div>
                        <label for="folder" class="block font-medium text-sm text-gray-700">Folder</label>
                        <select id="folder" name="folder" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                            <option value="" disabled>Select a folder</option>
                            @foreach($folders as $folder)
                            <option value="{{ $folder->id }}" {{ $folder->id == $docApproval->folder_id ? 'selected' :
                                '' }}>{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="documentNumber" class="block font-medium text-sm text-gray-700">Document
                            Number</label>
                        <input id="documentNumber" name="documentNumber" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $docApproval->document_number }}" required />
                    </div>

                    <div>
                        <label for="date" class="block font-medium text-sm text-gray-700">Date</label>
                        <input id="date" name="date" type="date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $docApproval->date }}" required />
                    </div>

                    <div>
                        <label for="documentStorage" class="block font-medium text-sm text-gray-700">Document
                            Storage</label>
                        <input id="documentStorage" name="documentStorage" type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $docApproval->document_storage }}" required />
                    </div>

                    <!-- Custom Add File Button -->
                    <div class="flex flex-col items-center justify-center mt-6">
                        <label id="upload-label" for="file-upload"
                            class="w-full cursor-pointer flex flex-col items-center bg-gray-200 border border-dashed border-gray-400 rounded-lg p-6 hover:bg-gray-300 transition-all">
                            <svg id="upload-icon" class="w-12 h-12 text-gray-500 mb-3"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span id="upload-text" class="text-gray-700 font-medium">Replace File</span>
                            <input type="file" id="file-upload" name="file" accept="application/pdf, image/*"
                                class="hidden" onchange="previewFile()" />
                        </label>
                    </div>

                    <div id="file-preview" class="mt-4">
                        @if($docApproval->file)
                        @php
                        $isPDF = strpos($docApproval->file, '%PDF-') === 0; // Check for PDF header
                        @endphp

                        @if($isPDF)
                        <iframe src="data:application/pdf;base64,{{ base64_encode($docApproval->file) }}"
                            type="application/pdf" width="100%" height="600px" class="mt-4 border rounded"></iframe>
                        @else
                        <img src="data:image/jpeg;base64,{{ base64_encode($docApproval->file) }}"
                            class="mt-4 w-full h-auto rounded" />
                        @endif
                        @else
                        <p class="text-gray-500">No file uploaded.</p>
                        @endif
                    </div>

                    <!-- Approval Section -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Approvals</h4>
                        <div id="approvals-container">
                            @foreach ($docApproval->approvals as $index => $approval)
                            <div class="approval-row flex gap-4 mb-4">
                                <div>
                                    <label for="approval_title" class="block font-medium text-sm text-gray-700">Approval
                                        Title</label>
                                    <input name="approvals[{{ $index }}][approval_title]" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        value="{{ $approval['approval_title'] ?? '' }}" required />
                                </div>
                                <div>
                                    <label for="approval_by" class="block font-medium text-sm text-gray-700">Approval
                                        By</label>
                                    <input name="approvals[{{ $index }}][approval_by]" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        value="{{ $approval['approval_by'] ?? '' }}" required />
                                </div>
                                <div>
                                    <label for="approval_date" class="block font-medium text-sm text-gray-700">Approval
                                        Date</label>
                                    <input name="approvals[{{ $index }}][approval_date]" type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                        value="{{ $approval['approval_date'] ?? '' }}" required />
                                </div>
                                <button type="button" class="remove-row text-red-500">Remove</button>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-approval"
                            class="mt-2 bg-gray-600 text-white font-bold py-2 px-4 rounded">Add Approval</button>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">Save</button>
                </form>
                <form method="POST" action="{{ route('doc-approval.destroy', $docApproval->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('Are you sure you want to delete this document?');">Delete</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let approvalCount = {{ count($docApproval->approvals) }}; // Counter for approval rows

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

            // Add event listener for the new remove button
            newRow.querySelector('.remove-row').addEventListener('click', function () {
                newRow.remove();
                updateRemoveButtons();
            });

            updateRemoveButtons(); // Update buttons state
        }

        // Add approval row on button click
        document.getElementById('add-approval').addEventListener('click', addApprovalRow);

        // Update remove buttons state
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.approval-row');
            const removeButtons = document.querySelectorAll('.remove-row');
            removeButtons.forEach(button => {
                if (rows.length === 1) {
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    button.disabled = false;
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        }

        // Initial call to updateRemoveButtons after page load
        updateRemoveButtons();

        // Add event listener for existing remove buttons (if any)
        document.querySelectorAll('.remove-row').forEach(button => {
            button.addEventListener('click', function (e) {
                e.target.closest('.approval-row').remove();
                updateRemoveButtons();
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
                    img.classList.add('mt-4', 'w-full', 'h-auto', 'rounded');
                    preview.appendChild(img);
                } else if (file.type === 'application/pdf') {
                    const iframe = document.createElement('iframe');
                    iframe.src = e.target.result;
                    iframe.type = 'application/pdf';
                    iframe.width = '100%';
                    iframe.height = '600px';
                    preview.appendChild(iframe);
                } else {
                    const link = document.createElement('a');
                    link.href = e.target.result;
                    link.textContent = file.name;
                    link.classList.add('mt-4', 'text-blue-600', 'underline');
                    link.target = '_blank';
                    preview.appendChild(link);
                }
            };
            reader.readAsDataURL(file);
            uploadLabel.classList.add('bg-gray-300');
            uploadText.textContent = file.name;
            uploadIcon.classList.add('hidden');
        }
    }
</script>


