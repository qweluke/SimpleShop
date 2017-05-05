<?php

namespace AppBundle\Products\Query;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Paginator;

class DoctrineProducts
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * DoctrineProducts constructor.
     * @param EntityManager $entityManager
     * @param Paginator $paginator
     */
    public function __construct(EntityManager $entityManager, Paginator $paginator)
    {
        $this->em = $entityManager;
        $this->paginator = $paginator;
    }

    public function getAllPaginated(int $page)
    {
        $query = $this->em->getRepository(Product::class)->getProductListQuery();
        $paginator = $this->paginator; //przekaz paginator do tego serwisu
        return $paginator->paginate($query, $page, 10);
    }
}