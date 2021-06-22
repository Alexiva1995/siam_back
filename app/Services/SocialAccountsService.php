<?php
namespace App\Services;

use App\User;
use App\LinkedSocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;
use App\Traits\CardNumber;

class SocialAccountsService
{
    use CardNumber;

    protected $image_service;

    public function __construct(ImageService $image_service) {
        $this->image_service = $image_service;
    }

    /**
     * Find or create user instance by provider user instance and provider name.
     * 
     * @param ProviderUser $providerUser
     * @param string $provider
     * 
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $linkedSocialAccount = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();
        if ($linkedSocialAccount) {
            $this->setUserAvatar($providerUser, $linkedSocialAccount->user);
            return $linkedSocialAccount->user;
        } else {
            $user = null;
            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }
            if (! $user) {
                do {
                    $card_number = $this->generateCardNumber();
                } while(User::where('card_number', $card_number)->count() > 0);

                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'card_number' => $card_number
                ]);
            }
            $this->setUserAvatar($providerUser, $user);
            $user->linkedSocialAccounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);
            return $user;
        }
    }

    private function setUserAvatar(ProviderUser $providerUser, $user) {
        if (!$user->image) {
            $avatar = $providerUser->avatar_original;
            if (empty($avatar)) {
                $avatar = $providerUser->getAvatar();
            }
            if (!empty($avatar)) {
                $image_data = $this->image_service->resizeAndStore($avatar);
            }

            $user->image = !empty($image_data) ? json_encode($image_data) : NULL;
            $user->save();
        }
    }
}