<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetailCommunity extends Model
{
    use HasFactory;

    protected $table = 'tb_user_details_community';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'community_name',
        'community_type',
        'social_media_url',
        'pic_name',
        'pic_national_id_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}