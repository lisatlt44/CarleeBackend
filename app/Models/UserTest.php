<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
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
