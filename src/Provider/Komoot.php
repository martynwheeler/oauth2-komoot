<?php
namespace MartynWheeler\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ResponseInterface;

class Komoot extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @var string Key used in the access token response to identify the resource owner.
     */
    const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'athlete.id';

    /**
     * @var string
     */

    const BASE_KOMOOT_URL = 'https://auth.komoot.de';

    /**
     * @var string
     */
    protected $apiVersion = 'v007';

    /**
     * Constructs an OAuth 2.0 service provider.
     *
     * @param array $options An array of options to set on this provider.
     *     Options include `clientId`, `clientSecret`, `redirectUri`, `state`, `apiVersion`.
     *     Individual providers may introduce more options, as needed.
     * @param array $collaborators An array of collaborators that may be used to
     *     override this provider's default behavior. Collaborators include
     *     `grantFactory`, `requestFactory`, `httpClient`, and `randomFactory`.
     *     Individual providers may introduce more collaborators, as needed.
     */
    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);

        foreach ($options as $option => $value) {
            if (property_exists($this, $option)) {
                $this->{$option} = $value;
            }
        }
    }

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return self::BASE_KOMOOT_URL . '/oauth/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        var_dump($params);
        return self::BASE_KOMOOT_URL . '/oauth/token';
    }

    protected function getAuthorizationHeaders($token = null)
    {
        return [
            'Bearer'            => $token,
            'USER_ACCESS_TOKEN' => $token,
        ];
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://external-api.komoot.de/' . $this->apiVersion . '/users/899720931594/tours/';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['profile'];
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['message'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new KomootResourceOwner($response);
    }

    /**
     * @return string
     */
    public function getBaseKomootUrl()
    {
        return self::BASE_KOMOOT_URL;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Returns the default headers used by this provider.
     *
     * Typically this is used to set 'Accept' or 'Content-Type' headers.
     *
     * @return array
     */
    protected function getDefaultHeaders()
    {
        return [
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/x-www-form-urlencoded;charset=UTF-8',
        ];
    }
}
