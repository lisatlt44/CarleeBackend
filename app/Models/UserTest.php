<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $table = 'user';
    protected $connection = 'mysql';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'birth_date',
        'phone',
        'password',
    ];
}
