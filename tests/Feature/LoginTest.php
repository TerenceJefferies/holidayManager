<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Ensures that a user can be created and login
     *
     * @return void
     */
    public function testUserCanLogin()
    {
        $user = factory('App\HolidayManager\User\User') -> create();
        $response = $this -> post('/login',[
            'email' => $user -> email,
            'password' => 'secret',
            '_token' => csrf_token()
        ]);
        $response -> assertRedirect('/home');
    }

    /**
      Tests to ensure a user providing an invalid password is redirected back to
      the root page

      @return void
    */
    public function testInvalidUserCannotLogin() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $response = $this -> post('/login',[
          'email' => $user -> email,
          'password' => 'wrongPassword',
          '_token' => csrf_token()
      ]);
      $response -> assertRedirect('/');
    }

}
