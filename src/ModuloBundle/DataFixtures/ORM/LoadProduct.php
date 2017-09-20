<?php

namespace ModuloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModuloBundle\Entity\Product;

class LoadProduct.php implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $products = [
            array('Oeuf','Rhône','France','Frais','Boîte de 12',3.50,'Oeuf'),
            array('Tomates','Rhône','France','Frais','200g',2.10,'Tomates'),
        ];
        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data[0])
                ->setOriginDepartment($data[1])
                ->setOriginCountry($data[2])
                ->setTemperature($data[3])
                ->setConditioning($data[4])
                ->setPrice($data[5])
                ->setType($data[6]);
            $manager->persist($product);
        }
        $manager->flush();
    }
}