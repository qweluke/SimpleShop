<?php

namespace AppBundle\Products\Command;

use Symfony\Component\Validator\Constraints as Assert;

class NewProductCommand
{
    /**
     * @var string
     * @Assert\NotNull()
     */
    public $name;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\Length(
     *     min="100",
     *     max="255",
     *     minMessage="form_product.validation.min"
     * )
     */
    public $description;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\Type(type="float", message="form_product.validation.price")
     */
    public $price;


}