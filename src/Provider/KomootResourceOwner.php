<?php
namespace MartynWheeler\OAuth2\Client\Provider;

class KomootResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response.
     *
     * @var array
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
     * Returns the identifier of the authorized resource owner.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->response['id'] ?: null;
    }

    /**
     * Returns resource owner first name.
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->response['username'] ?: null;
    }

    /**
     * Returns all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
