<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocApproval extends Model
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
        'approvals', // Menambahkan kolom approvals agar bisa diisi secara massal
    ];

    protected $casts = [
        'approvals' => 'array', // Menyatakan bahwa kolom approvals adalah array (JSON)
    ];

    // Relasi ke model Folder
    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }
}

