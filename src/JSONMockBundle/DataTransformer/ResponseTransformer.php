<?php

namespace JSONMockBundle\DataTransformer;

use Faker\Factory;

class ResponseTransformer
{
    public function transform($response)
    {
        $faker = Factory::create('pl_PL');

        $replace = array(
            "@sentence@" => $faker->sentence,
            "@word@" => $faker->word,
            "@integer@" => $faker->numberBetween(0, 100),
            "@largeInteger@" => $faker->numberBetween(),
            "@paragraph@" => $faker->paragraph,
            "@firstName@" => $faker->firstName,
            "@lastName@" => $faker->lastName,
            "@address@" => $faker->address,
            "@country@" => $faker->country,
            "@latitude@" => $faker->latitude,
            "@longitude@" => $faker->longitude,
            "@phoneNumber@" => $faker->phoneNumber,
            "@date@" => $faker->date,
            "@time@" => $faker->time,
            "@dayOfMonth@" => $faker->dayOfMonth,
            "@dayOfWeek@" => $faker->dayOfWeek,
            "@monthName@" => $faker->monthName,
            "@year@" => $faker->year,
            "@email@" => $faker->email,
            "@userName@" => $faker->userName,
            "@url@" => $faker->url,
            "@md5@" => $faker->md5
        );

        $response = json_encode($response);
        $response = strtr($response, $replace);
        $response = json_decode($response);

        return $response;
    }
}
