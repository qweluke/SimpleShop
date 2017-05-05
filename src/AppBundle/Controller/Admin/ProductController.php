<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Product;
use AppBundle\Form;
use AppBundle\Products\Command\NewProductCommand;
use AppBundle\Products\Handler\NewProductHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @package AppBundle\Controller\Admin
 *
 * @Route("/admin")
 */
class ProductController extends Controller
{

    private $commandBus;

    public function __construct()
    {
        $this->commandBus = new NewProductHandler();
    }

    /**
     * @Route("/new-product")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $object = new NewProductCommand();
        $formProduct = $this->createForm(Form\Product::class, $object);

        $formProduct->handleRequest($request);

        if($formProduct->isSubmitted() && $formProduct->isValid()) {

            $this->commandBus->handle($formProduct->getData());

            return $this->redirectToRoute('homepage');
        }

        // replace this example code with whatever you need
        return $this->render(':admin:productForm.html.twig', [
            'formProduct' => $formProduct->createView()
        ]);
    }
}
