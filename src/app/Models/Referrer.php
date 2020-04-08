<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $host
 * @property string $path
 */
class Referrer extends Model
{
  const CREATED_AT = null;
  const UPDATED_AT = null;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'host',
    'path',
  ];

  public function event()
  {
    return $this->hasMany(Event::class);
  }
}
