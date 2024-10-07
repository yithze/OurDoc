<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function destroy($id)
    {
        $folder = Folder::where('id', $id)
            ->where('user_id', auth()->id()) // Ensure the user owns the folder
            ->firstOrFail();

        $folder->delete(); // Delete the folder

        return redirect()->route('folder')->with('success', 'Folder deleted successfully.');
    }

    public function edit($id)
    {
        $folder = Folder::where('id', $id)
            ->where('user_id', auth()->id()) // Only get the folder if it belongs to the authenticated user
            ->firstOrFail(); // If folder not found, throw 404

        return view('folder-edit', compact('folder'));
    }

    public function update(Request $request, $id)
    {
        $folder = Folder::where('id', $id)
            ->where('user_id', auth()->id()) // Ensure the user owns the folder
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $folder->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('folder')->with('success', 'Folder updated successfully.');
    }

    public function index()
    {
        // Mengambil semua data folder yang dibuat oleh pengguna yang sedang terautentikasi
        $folders = Folder::where('user_id', auth()->id())->get();

        return view('folder', compact('folders')); // Kirim data ke view
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string|max:500',
    //     ]);
    //
    //     Folder::create([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //     ]);
    //
    //     return redirect()->route('folder')->with('success', 'Folder created successfully.');
    // }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        Folder::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(), // Menyimpan ID pengguna yang membuat folder
        ]);

        return redirect()->route('folder')->with('success', 'Folder created successfully.');
    }
}
