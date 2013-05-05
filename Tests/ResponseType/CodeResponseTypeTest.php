<?php

/*
 * This file is part of the pantarei/oauth2 package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pantarei\Oauth2\Test\ResponseType;

use Pantarei\Oauth2\ResponseType\CodeResponseType;

/**
 * Test code response type functionality.
 *
 * @author Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 */
class CodeResponseTypeTest extends \PHPUnit_Framework_TestCase
{
  public function testGetResponseType()
  {
    $grant_type = new CodeResponseType();
    $this->assertEquals('code', $grant_type->getResponseType());
  }
}