<?php

namespace AppBundle\Products\Handler;

use AppBundle\Entity\Product;
use AppBundle\Exception\InvalidProductException;
use AppBundle\Products\Command\NewProductCommand;
use AppBundle\Products\NewProductNotificationSender;
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
     * @var NewProductNotificationSender
     */
    private $mailer;

    /**
     * NewProductHandler constructor.
     * @param EntityManager $entityManager
     * @param ValidatorInterface $validator
     * @param NewProductNotificationSender $mailer
     */
    public function __construct(EntityManager $entityManager, ValidatorInterface $validator, NewProductNotificationSender $mailer)
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
        $productErrors = $this->validator->validate($productCommand);
        if ($productErrors->count()) {
            throw new InvalidProductException();
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
}
