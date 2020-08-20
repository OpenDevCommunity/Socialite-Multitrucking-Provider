<?php

namespace SocialiteProviders\MultiTrucking;

use SocialiteProviders\Manager\SocialiteWasCalled;

class MultitruckingExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('multitrucking', Provider::class);
    }
}