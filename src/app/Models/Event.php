<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $event
 * @property ?string $data
 * @property string $visitor_id
 * @property string $session_id
 * @property string $ip
 * @property string $host
 * @property string $path
 * @property ?int $referrer_id
 * @property ?int $user_agent_id
 * @property Carbon $created_at
 */
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

    'referrer_id',
    'user_agent_id',
  ];

  public function referrer()
  {
    return $this->belongsTo(Referrer::class);
  }

  public function userAgent()
  {
    return $this->belongsTo(UserAgent::class);
  }

  public function geoip()
  {
    return $this->belongsTo(GeoIp::class, 'ip', 'ip');
  }
}
