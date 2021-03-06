<?php

namespace AppBundle\Products;

use AppBundle\Entity\Product;

class NewProductNotificationSender
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * NewProductNotificationSender constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Product $product
     */
    public function sendNewProductEmail(Product $product)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('New product (' . $product->getName() . ') in the database!')
            ->setFrom('info@simple-shop.com')
            ->setTo('recipient@example.com')
            ->setBody('New fancy product. See description!: ' . $product->getDescription());

        $this->mailer->send($message);
    }
}