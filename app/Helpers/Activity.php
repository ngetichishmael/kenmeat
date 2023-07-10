<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\activity_log;

class Activity
{
   public function __invoke(
      $activity,
      $section,
      $action,
      $userID,
      $user_code,
      $ip,
      $app
   ) {

      activity_log::create([
         'source' => $app ?? "App",
         'activity' => $activity,
         'action' => $action,
         'userID' => $userID, // Replace with the actual user ID
         'section' => $section,
         'user_code' => $user_code,
         'business_code' => "36f4f9d6-f802-11ed-be45-f23c93158eb9",
         'activityID' => Str::uuid(),
         'ip_address' => $ip ?? "127.0.0.1",
      ]);
   }
}
