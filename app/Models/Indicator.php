<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'indicators';
  protected $connection = 'mysql';
  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'id_indicator';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'indicator_name',
    'description',
    'category',
    'indicator_color',
    'indicator_image'
  ];
}
