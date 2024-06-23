<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
   public static function connect()
   {
      $firebase = (new Factory)
         ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
         ->withDatabaseUri(env("FIREBASE_DATABASE_URL"));

      return $firebase->createDatabase();
   }

   public static function getStorage()
   {
      $firebase = (new Factory)
         ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
         ->withDefaultStorageBucket(env('FIREBASE_STORAGE_BUCKET'));
   
      return $firebase->createStorage();
   }

   public static function getFirestore()
   {
      $firebase = (new Factory)
         ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));

      return $firebase->createFirestore();
   }
}
