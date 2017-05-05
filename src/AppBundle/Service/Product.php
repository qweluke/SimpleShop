<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

class Product
{
    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function set()
    {

    }
}