<?php

namespace AppBundle\Products\Handler;

use AppBundle\Entity\Product;
use AppBundle\Products\Command\NewProductCommand;

class NewProductHandler
{
    public function handle(NewProductCommand $productCommand)
    {
        $product = new Product();
        $product
            ->setName($productCommand->name)
            ->setDescription($productCommand->description)
            ->setPrice($productCommand->price);


        // send email

    }
}