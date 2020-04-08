<?php

namespace Tests\Unit\Helpers;

use App\Helpers\UrlHelper;
use Tests\TestCase;

class UrlHelperTest extends TestCase
{
  public function test_getHost(): void
  {
    /** @var UrlHelper */
    $helper = app()->make(UrlHelper::class);
    $host = $helper->getHost('http://localhost/api/v1/users/123?action=test');

    $this->assertEquals('http://localhost', $host);
  }

  public function test_getPath(): void
  {
    /** @var UrlHelper */
    $helper = app()->make(UrlHelper::class);
    $path = $helper->getPath('http://localhost/api/v1/users/123?action=test');

    $this->assertEquals('/api/v1/users/123?action=test', $path);
  }
}
