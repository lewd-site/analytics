<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  const UPDATED_AT = null;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event',
    'data',

    'visitor_id',
    'session_id',
    'ip',

    'host',
    'path',
  ];
}
