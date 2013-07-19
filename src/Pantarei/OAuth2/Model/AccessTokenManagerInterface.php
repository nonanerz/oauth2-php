<?php

/**
 * This file is part of the pantarei/oauth2 package.
 *
 * (c) Wong Hoi Sing Edison <hswong3i@pantarei-design.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pantarei\OAuth2\Model;

interface AccessTokenManagerInterface extends ModelManagerInterface
{
    public function createAccessToken(
        $access_token,
        $token_type,
        $client_id,
        $username,
        $expires,
        $scope = array()
    );

    public function deleteAccessToken(AccessTokenInterface $access_token);

    public function reloadAccessToken(AccessTokenInterface $access_token);

    public function updateAccessToken(AccessTokenInterface $access_token);

    public function findAccessTokenByAccessToken($access_token);
}
