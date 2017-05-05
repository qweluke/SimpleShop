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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->get('product_handler')->getProductList(),
            $request->query->getInt('page', 1),
            10
        );

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
