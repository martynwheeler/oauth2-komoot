<?php

namespace MartynWheeler\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class KomootResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Get resource owner username
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, 'username');
    }

}
