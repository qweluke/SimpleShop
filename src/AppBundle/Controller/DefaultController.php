<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $list = $this->getDoctrine()->getRepository(Product::class)->getProductList();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $request->query->getInt('page', 1),
            10
        );

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
