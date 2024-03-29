<?php

/*
 * OAuth2 Client Bundle
 * Copyright (c) KnpUniversity <http://knpuniversity.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MartynWheeler\OAuth2\Client\Provider;

use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use MartynWheeler\OAuth2\Client\Provider\KomootResourceOwner;
use League\OAuth2\Client\Token\AccessToken;

class KomootClient extends OAuth2Client
{
    /**
     * @return KomootResourceOwner|\League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    public function fetchUserFromToken(AccessToken $accessToken)
    {
        return parent::fetchUserFromToken($accessToken);
    }

    /**
     * @return KomootResourceOwner|\League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    public function fetchUser()
    {
        return parent::fetchUser();
    }
}
