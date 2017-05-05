<?php

namespace AppBundle\Products\Handler;

use AppBundle\Entity\Product;
use AppBundle\Products\Command\NewProductCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NewProductHandler
{

    private $em;

    private $validator;

    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
    }

    public function handle(NewProductCommand $productCommand)
    {

        if($this->validator->validate($productCommand)->count()) {
            return false;
        }

        $product = new Product();
        $product
            ->setName($productCommand->name)
            ->setDescription($productCommand->description)
            ->setPrice($productCommand->price);

        $this->em->persist($product);
        $this->em->flush();


        // send email
        return $product->getId();
    }

    public function getProductList()
    {
        return $this->em->getRepository(Product::class)->getProductList();
    }
}