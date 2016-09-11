<?php

namespace App\Providers;

use SpamProtectionRequest;
use Illuminate\Support\ServiceProvider;
use Helge\SpamProtection\SpamProtection;

class SpamProtectionCacheServiceProvider extends SpamProtection
{

    public function boot() {

    }

    public function register() {

    }

    /*
     *  Extend SpamProtection library validation by caching the requests in the database
     */

    public function checkSaveRequest($key, $value) {

        //check if validation request cached and return result. If not then cache first
        $spamProtectionRequest = SpamProtectionRequest::firstOrCreate(['value' => $value]);

        if (isset($spamProtectionRequest->blacklisted)) {
            //if already in database then return if blacklisted
            $blacklisted = $spamProtectionRequest->blacklisted;

        } else {
            //if not already in DB then check if blacklisted and then store result
            $blacklisted = $this->check($key, $value);

            $spamProtectionRequest->key = $key;
            $spamProtectionRequest->value = $value;
            $spamProtectionRequest->blacklisted = $blacklisted;
            $spamProtectionRequest->save();

        }

        return (bool) $blacklisted;

    }

}
