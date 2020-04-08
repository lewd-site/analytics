<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $ip
 * @property string $type
 * @property string $hostname
 * @property string $continent
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $zip
 * @property float $latitude
 * @property float $longitude
 */
class GeoIp extends Model
{
  const CREATED_AT = null;
  const UPDATED_AT = null;

  /** @var string $table */
  protected $table = 'geoips';

  /** @var string $primaryKey */
  protected $primaryKey = 'ip';

  /** @var string $keyType */
  protected $keyType = 'string';

  /** @var bool $incrementing */
  public $incrementing = false;

  /** @var bool $timestamps */
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'ip',
    'type',
    'hostname',
    'continent',
    'country',
    'region',
    'city',
    'zip',
    'latitude',
    'longitude',
  ];

  protected $casts = [
    'latitude'  => 'float',
    'longitude' => 'float',
  ];

  public function event()
  {
    return $this->hasMany(Event::class, 'ip', 'ip');
  }
}
