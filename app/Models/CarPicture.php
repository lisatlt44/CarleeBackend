<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPicture extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'car_pictures';
  protected $connection = 'mysql';
  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'id';

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'picture',
    'picture_size',
    'is_active',
    'car_id'
  ];

  public function car()
  {
    return $this->belongsTo(Car::class);
  }
}
