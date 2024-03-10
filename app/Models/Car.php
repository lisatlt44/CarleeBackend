<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'cars';
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
    'name',
    'brand',
    'model',
    'color',
    'fuel_type',
    'production_date',
    'country_iso_code',
    'plate_number',
    'mileage',
    'last_maintenance_date',
    'is_active',
    'user_id'
  ];

  /**
   * Define the relationship with cars.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
