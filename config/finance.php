<?php

/*
|--------------------------------------------------------------------------
| Custom config values for the finance demo app
|--------------------------------------------------------------------------
*/

  return [

    'navbarLogo' => '/img/logo.svg',

    /*
    |--------------------------------------------------------------------------
    | Config values related to the user
    |--------------------------------------------------------------------------
    */
    'user' => [
      'profileImagePath' => '/img/profile/',
      'profileImageType' => 'png',
      'profileImageDimension' => '30px',
      'profileImageDefault' => 'default.png' //default image to use if the user has not provided an image
    ],

    /*
    |--------------------------------------------------------------------------
    | Config values related to transactions
    |--------------------------------------------------------------------------
    */
    'transaction' => [
      'numTransactionsToList' => 100,  //the number of transactions to list at once on the screen
      'maxLabelLength' => 35,          //the maximum character length for labels
      'maxAmount' => 5000,               //the maximum amount value
      'minAmount' => -5000,              //the minimum amount value
    ],

  ];
