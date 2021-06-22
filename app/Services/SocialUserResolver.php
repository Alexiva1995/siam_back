<?php
namespace App\Services;

use Exception;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;

class SocialUserResolver implements SocialUserResolverInterface
{

    protected $socialaccounts_service;
    public function __construct(SocialAccountsService $socialaccounts_service) {
        $this->socialaccounts_service = $socialaccounts_service;
    }

    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        $providerUser = null;

        try {
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (Exception $exception) {}
        
        if ($providerUser) {
            return $this->socialaccounts_service->findOrCreate($providerUser, $provider);
        }
        return null;
    }
}