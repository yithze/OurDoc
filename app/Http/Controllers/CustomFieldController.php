<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomFieldController extends Controller
{
    public function destroy($id)
    {
        // Mengambil data CustomField berdasarkan ID
        $customField = CustomField::findOrFail($id);

        // Menghapus custom field
        $customField->delete();

        return redirect()->route('search')->with('success', 'File deleted successfully.');
    }

    public function index()
    {
        // Mengambil data folder
        $folders = Folder::where('user_id', auth()->id())->get();

        // Mengambil data yang dibuat oleh pengguna
        $customFields = CustomField::where('user_id', Auth::id())->get();
        return view('custom-field', compact('customFields', 'folders'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'folder' => 'required|exists:folders,id',
            'documentNumber' => 'required|string|max:255',
            'date' => 'required|date',
            'documentStorage' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi file
        ]);

        // Mendapatkan konten file
        $fileContent = file_get_contents($request->file('file')->getRealPath());

        // Menyimpan data ke database
        CustomField::create([
            'name' => $request->name,
            'user_id' => Auth::id(), // ID pengguna yang meng-upload
            'folder_id' => $request->folder,
            'document_number' => $request->documentNumber,
            'date' => $request->date,
            'document_storage' => $request->documentStorage,
            'file' => $fileContent,
        ]);

        return redirect()->route('custom-field')->with('success', 'File uploaded successfully.');
    }

    public function edit($id)
    {
        // Mengambil data CustomField berdasarkan ID
        $customField = CustomField::findOrFail($id);
        $folders = Folder::where('user_id', auth()->id())->get(); // Ambil semua folder

        return view('custom-field-detail', compact('customField', 'folders'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'folder' => 'required|exists:folders,id',
            'documentNumber' => 'required|string|max:255',
            'date' => 'required|date',
            'documentStorage' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi file (opsional)
        ]);

        // Mengambil data CustomField berdasarkan ID
        $customField = CustomField::findOrFail($id);

        // Update data CustomField
        $customField->name = $request->name;
        $customField->folder_id = $request->folder;
        $customField->document_number = $request->documentNumber;
        $customField->date = $request->date;
        $customField->document_storage = $request->documentStorage;

        // Cek jika ada file baru yang diupload
        if ($request->hasFile('file')) {
            $fileContent = file_get_contents($request->file('file')->getRealPath());
            $customField->file = $fileContent; // Update konten file
        }

        // Simpan perubahan
        $customField->save();

        return redirect()->route('search')->with('success', 'File updated successfully.');
    }
}
