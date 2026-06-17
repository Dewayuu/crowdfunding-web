<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    protected $table = 'tb_user_documents';

    protected $primaryKey = 'user_document_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'document_type',
        'file',
        'uploaded_at',
        'verification_status',
        'rejection_reason',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}