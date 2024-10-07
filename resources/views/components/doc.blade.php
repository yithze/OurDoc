<div class="w-full bg-white shadow-lg rounded-lg p-4 flex items-center">
    <!-- Bagian Icon -->
    <div class="bg-black w-24 h-28 flex items-center justify-center rounded-l">
        {{ $icon }}
    </div>

    <!-- Bagian Detail Dokumen -->
    <div class="flex-1 pl-4">
        {{ $slot }}
    </div>
</div>

