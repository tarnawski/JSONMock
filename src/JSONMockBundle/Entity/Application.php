<?php

namespace JSONMockBundle\Entity;

class Application
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $responses;


    public function __construct()
    {
        $this->responses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param \JSONMockBundle\Entity\Response $response
     * @return Application
     */
    public function addResponse(\JSONMockBundle\Entity\Response $response)
    {
        if (!$this->responses->contains($response)) {
            $response->setApplication($this);
            $this->responses[] = $response;
        }
        return $this;
    }

    /**
     * @param \JSONMockBundle\Entity\Response $response
     */
    public function removeResponse(\JSONMockBundle\Entity\Response $response)
    {
        $this->responses->removeElement($response);
    }
}