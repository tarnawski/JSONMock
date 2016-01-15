<?php

namespace RestApiBundle\Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\WebApiExtension\Context\WebApiContext;
use Coduo\PHPMatcher\Factory\SimpleFactory;
use Coduo\PHPMatcher\Matcher;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SebastianBergmann\Diff\Differ;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Defines application features from the specific context.
 */
class ApiContext extends WebApiContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @BeforeScenario @cleanDB
     * @AfterScenario @cleanDB
     */
    public function cleanDB()
    {
        $application = new Application($this->getKernel());
        $application->setAutoExit(false);
        $application->run(new StringInput("doctrine:schema:drop --force -n -q"));
        $application->run(new StringInput("doctrine:schema:create -n -q"));
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @Given There are the following applications:
     */
    public function thereAreTheFollowingApplications(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $row) {
            $application = new \JSONMockBundle\Entity\Application();
            $application->setName($row['Name']);
            $application->setAppKey($row['APP_KEY']);
            $this->getManager()->persist($application);
            $this->getManager()->flush();
        }
        $this->getManager()->clear();
    }

    /**
     * @Then the JSON response should match:
     */
    public function theJsonResponseShouldMatch(PyStringNode $string)
    {
        $factory = new SimpleFactory();
        $matcher = $factory->createMatcher();
        $match = $matcher->match($this->response->getBody()->getContents(), $string->getRaw());
        \PHPUnit_Framework_Assert::assertTrue($match, $matcher->getError());
    }
}
