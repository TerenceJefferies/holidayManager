<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\HolidayManager\User\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory -> define(App\HolidayManager\HolidayTime\HolidayAllowance::class, function(Faker\Generator $faker) {
    return [
      'user_id' => function() {
        return factory('App\HolidayManager\User\User') -> create() -> id;
      },
      'days' => $faker -> numberBetween(10,50),
      'starts' => $faker -> dateTime(),
      'ends' => $faker -> dateTimeBetween('now','+1 years'),
      'period_name' => 'Year'
    ];
});

$factory -> define(App\HolidayManager\HolidayTime\HolidayExpenditure::class, function(Faker\Generator $faker) {
  $startDate = $faker -> dateTimeBetween('now','+1 years');
  $endDateEnd = clone $startDate;
  $endDateEnd -> add(new DateInterval('P10D'));
  $endDate = $faker -> dateTimeBetween($startDate,$endDateEnd);
  return [
    'allowance_id' => function() {
      return factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create() -> id;
    },
    'days' => $faker -> numberBetween(10,50),
    'starts' => $startDate,
    'ends' => $endDate,
    'status' => $faker -> randomElement(['approved','pending','rejected'])
  ];
});
