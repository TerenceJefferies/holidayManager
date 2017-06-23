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
        factory(App\HolidayManager\User\User::class, 10) -> create() -> each(function($user) {
          factory(App\HolidayManager\HolidayTime\HolidayAllowance::class,1) -> create(['user_id' => $user -> id]) -> each(function($allowance) {
            factory(App\HolidayManager\HolidayTime\HolidayExpenditure::class,1) -> create([
              'allowance_id' => $allowance -> id,
              'days' => ($allowance -> days / rand(1,4))
            ]);
          });
        });
    }
}
