<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $user_agent
 */
class UserAgent extends Model
{
  const CREATED_AT = null;
  const UPDATED_AT = null;

  /** @var bool $timestamps */
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_agent',
  ];

  public function event()
  {
    return $this->hasMany(Event::class);
  }
}
