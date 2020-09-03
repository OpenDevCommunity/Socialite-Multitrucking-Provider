<?php

namespace SocialiteProviders\MultiTrucking;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;


class Provider extends AbstractProvider {

    protected $scopes =  array('profile');

    /**
     * Unique Provider Identifier
     */
    public const  IDENTIFIER = 'MULTITRUCKING';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://multitrucking.com/oauth/authorize/', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://multitrucking.com/oauth/token/';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://multitrucking.com/api/core/me', [
            'headers' => [
                // 'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function getFromConfig($arrayKey)
    {
        return app()['config']['services.multitrucking'][$arrayKey];
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => $user['photoUrl'],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}
