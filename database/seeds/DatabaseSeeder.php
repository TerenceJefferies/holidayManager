<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this -> createUserProfile(['count' => 10]);
        $this -> createStaticUser();
    }

    /**
      Helper method to create a user whos details are known and can be used
      in the test enviroment

      @return void
    */
    private function createStaticUser() {
      $this -> createUserProfile(['userData' =>
        [
          'email' => 'tester@example.com',
          'password' => bcrypt('password')
        ],
        'expenditureCount' => 10
      ]);
    }

    /**
      Creates user profiles in a centralised manner, allows overrides to be
      provided for certain variables

      @param Array $overrides Any overrides that should be added to this profile
    */
    protected function createUserProfile($overrides=[]) {
      if(!isset($overrides['count'])) { $overrides['count'] = 1; }
      if(!isset($overrides['expenditureCount'])) { $overrides['expenditureCount'] = 1; }
      if(!isset($overrides['userData'])) { $overrides['userData'] = []; }
      factory(App\HolidayManager\User\User::class, $overrides['count']) -> create($overrides['userData']) -> each(function($user) use ($overrides) {
        factory(App\HolidayManager\HolidayTime\HolidayAllowance::class,1) -> create(['user_id' => $user -> id]) -> each(function($allowance) use ($overrides) {
          factory(App\HolidayManager\HolidayTime\HolidayExpenditure::class,$overrides['expenditureCount']) -> create([
            'allowance_id' => $allowance -> id,
            'days' => ($allowance -> days / rand(2,4))
          ]);
        });
      });
    }
}
