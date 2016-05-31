<?php

namespace JSONMockBundle\DataTransformer;

use Faker\Factory;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ResponseTransformer
{
    public function transform($response)
    {
        $faker = Factory::create('pl_PL');

        $patterns = array(
            "@sentence@" => 'sentence',
            "@word@" => 'word',
            "@integer@" => 'numberBetween',
            "@largeInteger@" => 'numberBetween',
            "@paragraph@" => 'paragraph',
            "@firstName@" => 'firstName',
            "@lastName@" => 'lastName',
            "@address@" => 'address',
            "@country@" => 'country',
            "@latitude@" => 'latitude',
            "@longitude@" => 'longitude',
            "@phoneNumber@" => 'phoneNumber',
            "@date@" => 'date',
            "@time@" => 'time',
            "@dayOfMonth@" => 'dayOfMonth',
            "@dayOfWeek@" => 'dayOfWeek',
            "@monthName@" => 'monthName',
            "@year@" => 'year',
            "@email@" => 'email',
            "@userName@" => 'userName',
            "@url@" => 'url',
            "@md5@" => 'md5'
        );

        $response = json_encode($response);
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach($patterns as $pattern=>$value){
            while(strstr($response, $pattern)){
                $response = $this->replaceFirst(
                    $pattern,
                    $accessor->getValue($faker, $value),
                    $response
                );
            }
        }

        $response = json_decode($response);

        return $response;
    }

    private function replaceFirst($from, $to, $subject)
    {
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $subject, 1);
    }
}
