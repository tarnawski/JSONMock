<?php

namespace JSONMockBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JSONMockBundle\Entity\Response;
use Faker\Factory;

class LoadResponseData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    const RESPONSE_NUMBER = 800;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('pl_PL');
        $arrayOfMethod = ['POST', 'GET', 'DELETE', 'PUT'];
        $arrayOfStatusCode = [200, 201, 403, 500];

        for ($i = 0; $i < self::RESPONSE_NUMBER; $i++) {
            $response = new Response();
            $response->setName($faker->word);
            $response->setValue("{'" .$faker->word. "': '" .$faker->word. "'}");
            $key = array_rand($arrayOfMethod);
            $response->setMethod($arrayOfMethod[$key]);
            $key = array_rand($arrayOfStatusCode);
            $response->setStatusCode($arrayOfStatusCode[$key]);
            $random = rand(0, LoadApplicationData::APPLICATIONS_NUMBER - 1);
            $application = $this->getReference(sprintf('application-%s', $random));
            $response->setApplication($application);
            $manager->persist($response);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
