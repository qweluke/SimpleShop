<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Products\Command\NewProductCommand;
use AppBundle\Products\Handler\NewProductHandler;
use Mockery as m;
use PHPUnit\Framework\TestCase;


class AdminControllerTest extends TestCase
{
    public function testAddSuccessProduct()
    {
        $product = new NewProductCommand();
        $product->name = 'Product name!';
        $product->description = 'Hi, I want to sell my new boat. It is my treasure so I will send it only to ppl that will take care about her! Only cash, no credits cards or coupons!';
        $product->price = 141.12;

        $entityManagerMock = m::mock('Doctrine\ORM\EntityManager');
        $entityManagerMock
            ->shouldReceive('persist')->withArgs([$product])->once()
            ->with(m::on(function ($args) use ($product) {
                if (!($args instanceof Product)) {
                    return false;
                }
                if ($args->getDescription() !== $product->description ||
                    $args->getName() !== $product->name ||
                    $args->getPrice() !== $product->price
                ) {
                    return false;
                }

                return true;
            }));
        $entityManagerMock->shouldReceive('flush')->once();

        $validatorMock = m::mock('Symfony\Component\Validator\Validator\ValidatorInterface');

        $validatorMockCollection = m::mock('Symfony\Component\Validator\ConstraintViolationList');
        $validatorMockCollection->shouldReceive('count')->withNoArgs();

        $validatorMock->shouldReceive('validate')->withArgs([$product])->once()
            ->andReturn($validatorMockCollection);

        $productNotificationSenderMock = m::mock('AppBundle\Products\NewProductNotificationSender');
        $productNotificationSenderMock->shouldReceive('sendNewProductEmail')->withArgs([$product])->once()
            ->with(m::on(function ($args) use ($product) {
                if (!($args instanceof Product)) {
                    return false;
                }
                if ($args->getDescription() !== $product->description ||
                    $args->getName() !== $product->name ||
                    $args->getPrice() !== $product->price
                ) {
                    return false;
                }

                return true;
            }));

        $productHandler = new NewProductHandler($entityManagerMock, $validatorMock, $productNotificationSenderMock);
        $productHandler->handle($product);
    }

    /**
     * @expectedException AppBundle\Exception\InvalidProductException
     */
    public function testAddFailProduct()
    {
        $product = new NewProductCommand();
        $product->name = 'Product name!';
        $product->description = 'Hi, I want to sell my new boat. It is my treasure so I will send it only to ppl that will take care about her! Only cash, no credits cards or coupons!';
        $product->price = 141.12;

        $entityManagerMock = m::mock('Doctrine\ORM\EntityManager');
        $entityManagerMock->shouldNotReceive('persist');
        $entityManagerMock->shouldNotReceive('flush');

        $validatorMock = m::mock('Symfony\Component\Validator\Validator\ValidatorInterface');

        $validatorMockCollection = m::mock('Symfony\Component\Validator\ConstraintViolationList');
        $validatorMockCollection->shouldReceive('count')->withNoArgs()->andReturn(2);

        $validatorMock->shouldReceive('validate')->withArgs([$product])->once()
            ->andReturn($validatorMockCollection);

        $productNotificationSenderMock = m::mock('AppBundle\Products\NewProductNotificationSender');
        $productNotificationSenderMock->shouldNotReceive('sendNewProductEmail');
        $productHandler = new NewProductHandler($entityManagerMock, $validatorMock, $productNotificationSenderMock);
        $productHandler->handle($product);
    }

    public function tearDown()
    {
        m::close();
    }


}
