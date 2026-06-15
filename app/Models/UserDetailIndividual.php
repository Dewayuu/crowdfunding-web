<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetailIndividual extends Model
{
    use HasFactory;

    protected $table = 'tb_user_details_individual';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'national_id_number',
        'birth_date',
        'gender',
    ];

    /**
     * Relasi Balik (Belongs To) ke tabel induk tb_users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}