<x-app-layout>
    @slot('title', 'Custom Field')
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
            <a href="{{ route('custom-field') }}" class="ml-3">Custom Field</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-14">
                <h3 class="text-lg font-medium text-gray-900">Upload File</h3>
                <form method="POST" action="{{ route('custom-field.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
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

                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
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
                // Create image or PDF preview based on the file type
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
                    embed.height = '600px'; // Adjust height as needed
                    preview.appendChild(embed);
                } else {
                    preview.textContent = 'File type not supported for preview';
                }

                // Change the label to show the file name and a replace button
                uploadText.textContent = file.name;
                uploadIcon.classList.add('hidden'); // Hide the plus icon

                const replaceButton = document.createElement('button');
                // replaceButton.textContent = 'Replace';
                // replaceButton.classList.add('bg-gray-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded', 'mt-2');
                replaceButton.type = 'button';
                replaceButton.onclick = function () {
                    fileInput.click(); // Trigger file input click to replace the file
                };
                uploadLabel.appendChild(replaceButton);
            };
            reader.readAsDataURL(file);
        }
    }
</script>

