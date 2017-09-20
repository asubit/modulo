<?php

namespace ModuloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ModuloBundle\Repository\ProductRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("ModuloBundle:Product")->findAll();

        return $this->render(
            'ModuloBundle:Default:index.html.twig',
            array(
                'products' => $products
            )
        );
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return $this->render('ModuloBundle:Default:admin.html.twig');
    }

    /**
     * @Route("/find-match", name="find_match")
     * @Method({"GET", "POST"})
     */
    public function findMatchAction()
    {
        $em = $this->getDoctrine()->getManager();

        $zipCode = $this->get('request')->request->get('zip_code');
        $productId = $this->get('request')->request->get('product_id');
        $matchs = $em->getRepository("ModuloBundle:Product")->findClose($zipCode, $productId);
        return $this->render(
            'ModuloBundle:Default:find-match.html.twig',
            array(
                'matchs' => $matchs
            )
        );
    }


}
