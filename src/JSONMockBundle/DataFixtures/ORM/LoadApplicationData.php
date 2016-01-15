<?php

namespace JSONMockBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JSONMockBundle\Entity\Application;
use Faker\Factory;

class LoadApplicationData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    const APPLICATIONS_NUMBER = 50;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('pl_PL');
        for ($i = 0; $i < self::APPLICATIONS_NUMBER; $i++) {
            $application = new Application();
            $application->setSecret(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"));
            $application->setName($faker->sentence(2));
            $this->addReference(sprintf('application-%s', $i), $application);
            $manager->persist($application);
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
        return 1;
    }
}
