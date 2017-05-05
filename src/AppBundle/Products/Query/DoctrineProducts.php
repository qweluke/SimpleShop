<?php

namespace AppBundle\Products\Query;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class DoctrineProducts
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * DoctrineProducts constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getAll(): QueryBuilder
    {
        return $this->em->getRepository(Product::class)->getProductList();
    }
}