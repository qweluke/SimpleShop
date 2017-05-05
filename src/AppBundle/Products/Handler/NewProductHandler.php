<?php

namespace AppBundle\Products\Handler;

use AppBundle\Entity\Product;
use AppBundle\Products\Command\NewProductCommand;
use AppBundle\Service\Mailer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NewProductHandler
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * NewProductHandler constructor.
     * @param EntityManager $entityManager
     * @param ValidatorInterface $validator
     * @param Mailer $mailer
     */
    public function __construct(EntityManager $entityManager, ValidatorInterface $validator, Mailer $mailer)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
        $this->mailer = $mailer;
    }

    /**
     * @param NewProductCommand $productCommand
     * @return bool|int
     */
    public function handle(NewProductCommand $productCommand)
    {

        if ($this->validator->validate($productCommand)->count()) {
            return false;
        }

        $product = new Product();
        $product
            ->setName($productCommand->name)
            ->setDescription($productCommand->description)
            ->setPrice($productCommand->price);

        $this->em->persist($product);
        $this->em->flush();

        $this->mailer->sendNewProductEmail($product);

        return $product->getId();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getProductList()
    {
        return $this->em->getRepository(Product::class)->getProductList();
    }
}
