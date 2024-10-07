<?php

namespace App\Http\Controllers;
use App\Models\DocApproval;
use App\Models\Entry;
use App\Models\CustomField;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index()
{
    $userId = Auth::id();

    $entries = Entry::where('user_id', $userId)->get();
    $folders = Folder::where('user_id', $userId)->get();
    $customFields = CustomField::where('user_id', $userId)->get();
    $docApprovals = DocApproval::where('user_id', $userId)->get();

    return view('search', compact('entries', 'customFields', 'folders', 'docApprovals'));
}

}
