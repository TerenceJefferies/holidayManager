<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AllowanceTest extends TestCase
{

    use DatabaseMigrations;

    private $user;

    public function setUp()
    {
      parent::setUp();
      $this -> user = factory('App\HolidayManager\User\User') -> create();
    }

    /**
     * Tests to ensure a user cannot view another users allowance
     *
     * @return void
     */
    public function testUserCannotViewAnotherUsersAllowance()
    {
      $this -> be($this -> user);
      $alternativeUser = factory('App\HolidayManager\User\User') -> create();
      $ownedAllowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $this -> user -> id]);
      $unownedAllowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $alternativeUser]);
      $response = $this -> get('/allowance/show/' . $ownedAllowance -> id);
      $response -> assertStatus(200);
      $failResponse = $this -> get('/allowance/show/' . $unownedAllowance -> id);
      $failResponse -> assertRedirect('/home');
    }
}
