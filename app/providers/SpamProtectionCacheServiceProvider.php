<?php

namespace App\Providers;

use SpamProtectionRequest;
use Illuminate\Support\ServiceProvider;
use Helge\SpamProtection\SpamProtection;
use Carbon\Carbon;

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

        if (isset($spamProtectionRequest->updated_at) && ($spamProtectionRequest->updated_at->timestamp < Carbon::now()->subDays(30)->timestamp)) {

            //if cached request exitent and older than 30 days then check and update request
            $blacklisted = $this->check($key, $value);

            $spamProtectionRequest->key = $key;
            $spamProtectionRequest->value = $value;
            $spamProtectionRequest->blacklisted = $blacklisted;
            $spamProtectionRequest->update();

        } elseif (isset($spamProtectionRequest->blacklisted)) {

            //if already in database and not older than 30 days then return request
            $blacklisted = $spamProtectionRequest->blacklisted;

        } else {

            //if not already in database then check and store result
            $blacklisted = $this->check($key, $value);

            $spamProtectionRequest->key = $key;
            $spamProtectionRequest->value = $value;
            $spamProtectionRequest->blacklisted = $blacklisted;
            $spamProtectionRequest->save();

        }

        return (bool) $blacklisted;

    }

}
