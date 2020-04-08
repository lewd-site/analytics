<?php

namespace App\Services;

use App\Models\GeoIp;
use Exception;

class IpStackService
{
  protected function lookup(string $ip): GeoIp
  {
    $apiKey = config('services.ipstack.api_key');
    if (!isset($apiKey)) {
      throw new Exception('IPStack API key is not set');
    }

    $url = "http://api.ipstack.com/$ip?access_key=$apiKey&fields=main&hostname=1";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return GeoIp::create([
      'ip'        => $ip,
      'type'      => $data['type'],
      'hostname'  => $data['hostname'],
      'continent' => $data['continent_name'],
      'country'   => $data['country_name'],
      'region'    => $data['region_name'],
      'city'      => $data['city'],
      'zip'       => $data['zip'],
      'latitude'  => $data['latitude'],
      'longitude' => $data['longitude'],
    ]);
  }

  public function getGeoIp(string $ip): GeoIp
  {
    $geoIp = GeoIp::find($ip);
    if (isset($geoIp)) {
      return $geoIp;
    }

    return $this->lookup($ip);
  }
}
