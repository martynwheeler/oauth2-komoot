Configuration:
```
knpu_oauth2_client:
    clients:
        # configure your clients as described here: https://github.com/knpuniversity/oauth2-client-bundle#configuration
        # will create service: "knpu.oauth2.client.komoot_oauth"
        # an instance of: KnpU\OAuth2ClientBundle\Client\OAuth2Client
        komoot_oauth:
            type: generic
            provider_class: MartynWheeler\OAuth2\Client\Provider\Komoot

            # optional: a class that extends OAuth2Client
            client_class: MartynWheeler\OAuth2\Client\Provider\KomootClient

            # optional: if your provider has custom constructor options
            # provider_options: {}

            # now, all the normal options!
            client_id: '%env(KOMOOT_ID)%'
            client_secret: '%env(KOMOOT_SECRET)%'
            redirect_route: connect_rwgps_check
            redirect_params: {}
```

Useage:
```
<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RwgpsController extends Controller
{
    /**
     * @Route("/connect/rwgps", name="connect_rwgps")
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        // on Symfony 3.3 or lower, $clientRegistry = $this->get('knpu.oauth2.registry');

        // will redirect to Komoot!
        return $clientRegistry
            ->getClient('komoot_oauth') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
	    	'profile' // the scopes you want to access
            ])
        ;
	}

    /**
     * After going to Komoot, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/rwgps/check", name="connect_rwgps_check")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \MartynWheeler\OAuth2\Client\Provider\Komoot $client */
        $client = $clientRegistry->getClient('komoot_oauth');

        try {
            // the exact class depends on which provider you're using
            /** @var \MartynWheeler\OAuth2\Client\Provider\KomootResourceOwner $user */
            $user = $client->fetchUser();
      // do something with all this new power!
	    // e.g. $name = $user->getFirstName();
            var_dump($user); die;
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage()); die;
        }
    }
}
```
