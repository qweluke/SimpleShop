<?php

namespace AppBundle\Controller;

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
            $this->get('products_doctrine')->getAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('default/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
