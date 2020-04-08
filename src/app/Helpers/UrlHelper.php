<?php

namespace App\Helpers;

use Exception;

class UrlHelper
{
  /**
   * @throws Exception
   */
  public function getHost(string $url): string
  {
    $data = parse_url($url);
    if (empty($data)) {
      throw new Exception('Invalid URL');
    }

    $host = $data['scheme'] ?? 'http';
    $host .= '://' . $data['host'];

    if (isset($data['port'])) {
      $host .= ':' . $data['post'];
    }

    return $host;
  }

  /**
   * @throws Exception
   */
  public function getPath(string $url): string
  {
    $data = parse_url($url);
    if (empty($data)) {
      throw new Exception('Invalid URL');
    }

    $path = $data['path'];

    if (isset($data['query'])) {
      $path .= '?' . $data['query'];
    }

    if (isset($data['fragment'])) {
      $path .= '#' . $data['fragment'];
    }

    return $path;
  }
}
