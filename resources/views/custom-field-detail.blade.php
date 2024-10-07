<x-app-layout>
    @slot('title', 'Edit Custom Field')
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
            <a href="{{ route('search') }}" class="ml-3 mr-3 text-gray-500">Search</a>
            >
            <a class="ml-3">Custom Field Detail</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-14">
                <h3 class="text-lg font-medium text-gray-900">Edit File</h3>
                <form method="POST" action="{{ route('custom-field.update', $customField->id) }}"
                    enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT') <!-- Menambahkan metode PUT untuk update -->

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $customField->name) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="folder" class="block font-medium text-sm text-gray-700">Folder</label>
                        <select id="folder" name="folder" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required>
                            <option value="" disabled>Select a folder</option>
                            @foreach($folders as $folder)
                            <option value="{{ $folder->id }}" {{ $folder->id == $customField->folder_id ? 'selected' :
                                '' }}>{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="documentNumber" class="block font-medium text-sm text-gray-700">Document
                            Number</label>
                        <input id="documentNumber" name="documentNumber" type="text"
                            value="{{ old('documentNumber', $customField->document_number) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="date" class="block font-medium text-sm text-gray-700">Date</label>
                        <input id="date" name="date" type="date" value="{{ old('date', $customField->date) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <div>
                        <label for="documentStorage" class="block font-medium text-sm text-gray-700">Document
                            Storage</label>
                        <input id="documentStorage" name="documentStorage" type="text"
                            value="{{ old('documentStorage', $customField->document_storage) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                    </div>

                    <!-- Bagian Upload File -->
                    <div>
                        <!-- <label for="file-upload" class="block font-medium text-sm text-gray-700">File</label> -->
                        <div class="flex items-center">
                            <!-- Label untuk memilih file -->
                            <label id="file-label" for="file-upload" class="flex flex-col items-center justify-center cursor-pointer bg-gray-200 border border-dashed border-gray-400 rounded-lg p-6 hover:bg-gray-300 transition-all w-full">
                                <svg id="file-icon" class="w-12 h-12 text-gray-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span id="file-text" class="text-gray-700 font-medium">Replace File</span>
                            </label>
                            <input type="file" id="file-upload" name="file" accept="application/pdf, image/*" class="hidden" onchange="handleFileChange()" />
                        </div>
                    </div>

                    <!-- Preview File -->
                    <div id="file-preview" class="mt-4">
                        @if($customField->file)
                        @php
                        $isPDF = strpos($customField->file, '%PDF-') === 0; // Memeriksa header PDF
                        $fileType = $isPDF ? 'application/pdf' : 'image/jpeg'; // Asumsi jika tidak PDF adalah gambar JPEG
                        @endphp

                        @if($isPDF)
                        <embed src="data:application/pdf;base64,{{ base64_encode($customField->file) }}"
                            type="application/pdf" width="100%" height="600px" />
                        @else
                        <img src="data:image/jpeg;base64,{{ base64_encode($customField->file) }}"
                            class="mt-4 w-full h-auto" />
                        @endif
                        @else
                        <p class="text-gray-500">No file uploaded.</p>
                        @endif
                    </div>

                    <!-- Tombol Update -->
                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-black text-white font-bold py-2 px-4 rounded">Update</button>
                </form>
                <form method="POST" action="{{ route('custom-field.destroy', $customField->id) }}">
                @csrf
                @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this file?')">
                        Delete
                    </button>
                </form>
                    </div>
            </div>

        </div>
</x-app-layout>

<!-- Script Preview File -->
<script>
    function handleFileChange() {
        const file = document.getElementById('file-upload').files[0];
        const fileLabel = document.getElementById('file-label');
        const fileText = document.getElementById('file-text');
        const fileIcon = document.getElementById('file-icon');
        const preview = document.getElementById('file-preview');

        // Clear previous preview
        preview.innerHTML = '';

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                fileText.textContent = file.name; // Menampilkan nama file
                fileIcon.classList.add('hidden'); // Menyembunyikan ikon setelah file dipilih

                // Preview file sesuai tipe (gambar atau PDF)
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
                    embed.height = '600px'; // Atur tinggi sesuai kebutuhan
                    preview.appendChild(embed);
                } else {
                    preview.textContent = 'File type not supported for preview';
                }
            };
            reader.readAsDataURL(file);
        }
    }
</script>

