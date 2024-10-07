<?php

namespace App\Http\Controllers;

use App\Models\DocApproval;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocApprovalController extends Controller
{
    public function destroy($id)
    {
        // Find the document approval record by ID
        $docApproval = DocApproval::findOrFail($id);

        // Delete the document
        $docApproval->delete();

        return redirect()->route('search')->with('success', 'Document deleted successfully.');
    }

    public function index()
    {
        // Mengambil data folder
        $folders = Folder::where('user_id', auth()->id())->get();

        // Mengambil data yang dibuat oleh pengguna
        $docApprovals = DocApproval::where('user_id', Auth::id())->get();
        return view('doc-approval', compact('docApprovals', 'folders'));
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
            'approvals' => 'required|array', // Pastikan approvals adalah array
            'approvals.*.approval_title' => 'required|string|max:255',
            'approvals.*.approval_by' => 'required|string|max:255',
            'approvals.*.approval_date' => 'required|date',
        ]);

        // Mendapatkan konten file
        $fileContent = file_get_contents($request->file('file')->getRealPath());

        // Menyimpan data ke database
        DocApproval::create([
            'name' => $request->name,
            'user_id' => Auth::id(), // ID pengguna yang meng-upload
            'folder_id' => $request->folder,
            'document_number' => $request->documentNumber,
            'date' => $request->date,
            'document_storage' => $request->documentStorage,
            'file' => $fileContent,
            'approvals' => $request->approvals, // Menyimpan data approval sebagai JSON
        ]);

        return redirect()->route('doc-approval')->with('success', 'File uploaded successfully.');
    }

    public function edit($id)
    {
        // Mengambil data DocApproval berdasarkan ID
        $docApproval = DocApproval::findOrFail($id);
        $folders = Folder::where('user_id', auth()->id())->get(); // Ambil semua folder

        return view('doc-approval-detail', compact('docApproval', 'folders'));
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
            'approvals' => 'required|array', // Validasi approvals sebagai array
            'approvals.*.approval_title' => 'required|string|max:255',
            'approvals.*.approval_by' => 'required|string|max:255',
            'approvals.*.approval_date' => 'required|date',
        ]);

        // Mengambil data DocApproval berdasarkan ID
        $docApproval = DocApproval::findOrFail($id);

        // Update data DocApproval
        $docApproval->name = $request->name;
        $docApproval->folder_id = $request->folder;
        $docApproval->document_number = $request->documentNumber;
        $docApproval->date = $request->date;
        $docApproval->document_storage = $request->documentStorage;
        $docApproval->approvals = $request->approvals; // Update data approval

        // Cek jika ada file baru yang diupload
        if ($request->hasFile('file')) {
            $fileContent = file_get_contents($request->file('file')->getRealPath());
            $docApproval->file = $fileContent; // Update konten file
        }

        // Simpan perubahan
        $docApproval->save();

        return redirect()->route('search')->with('success', 'File updated successfully.');
    }
}
