<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    // public function update(Request $request, $id)
    // {
    //     $entry = Entry::findOrFail($id);
    //
    //     $entry->update($request->all());
    //
    //     return redirect()->route('entry-data')->with('success', 'Entry updated successfully!');
    // }
    public function destroy($id)
    {
        // Find the entry by ID or fail if it doesn't exist
        $entry = Entry::findOrFail($id);

        // Delete the entry
        $entry->delete();

        // Redirect with success message
        return redirect()->route('search')->with('success', 'Entry deleted successfully.');
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
            'table_data' => 'required|json',
        ]);

        // Cari entry berdasarkan ID
        $entry = Entry::findOrFail($id);

        // Update field-field yang diperlukan
        $entry->update([
            'name' => $request->name,
            'folder_id' => $request->folder,
            'document_number' => $request->documentNumber, // Update document number secara eksplisit
            'date' => $request->date,
            'document_storage' => $request->documentStorage,
            'table_data' => $request->table_data,
        ]);

        return redirect()->route('search')->with('success', 'Entry updated successfully!');
    }


    // public function edit($id)
    // {
    //     $entry = Entry::findOrFail($id);
    //     $folders = Folder::all(); // Ambil semua folder untuk dropdown
    //
    //     return view('entry-data-detail', compact('entry', 'folders'));
    // }
    public function edit($id)
    {
        $entry = Entry::findOrFail($id);
        // $folders = Folder::all(); // Ambil semua folder untuk dropdown
        $folders = Folder::where('user_id', auth()->id())->get();

        // Dekode table_data dari JSON ke array
        $existingTableData = json_decode($entry->table_data, true); // true untuk mendapatkan array asosiatif

        return view('entry-data-detail', compact('entry', 'folders', 'existingTableData'));
    }


    public function index()
    {
        $userId = Auth::id(); // Get the currently logged-in user's ID
        $entries = Entry::where('user_id', $userId)->get(); // Get entries for this user

        return view('search', compact('entries'));
    }
    public function show($id)
    {
        $entry = Entry::findOrFail($id); // Ambil entry berdasarkan ID
        return view('nama-viewmu', compact('entry')); // Kirim entry ke view
    }



    public function create()
    {
        // Optionally, retrieve folders to show in the create form

        // $folders = Folder::all();
        $folders = Folder::where('user_id', auth()->id())->get();
        return view('entry-data', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'folder' => 'required|exists:folders,id',
            'documentNumber' => 'required|string|max:255',
            'date' => 'required|date',
            'documentStorage' => 'required|string|max:255',
            'table_data' => 'required|json',
        ]);

        Entry::create([
            'user_id' => Auth::id(), // Store the authenticated user's ID
            'name' => $request->name,
            'folder_id' => $request->folder,
            'document_number' => $request->documentNumber,
            'date' => $request->date,
            'document_storage' => $request->documentStorage,
            'table_data' => $request->table_data,
        ]);

        return redirect()->route('entry-data')->with('success', 'Entry created successfully.');
    }

    // Add methods for show, edit, update, and delete as needed
}
