<?php

namespace AppBundle\Products\Handler;

use AppBundle\Entity\Product;
use AppBundle\Products\Command\NewProductCommand;
use Doctrine\ORM\EntityManager;

class NewProductHandler
{

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function handle(NewProductCommand $productCommand)
    {
        $product = new Product();
        $product
            ->setName($productCommand->name)
            ->setDescription($productCommand->description)
            ->setPrice($productCommand->price);


        $this->em->persist($product);
        $this->em->flush();


        // send email

    }
}