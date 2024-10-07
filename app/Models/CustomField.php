<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'folder_id',
        'document_number',
        'date',
        'document_storage',
        'file',
    ];
        // Relasi ke model Folder
    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }
}

