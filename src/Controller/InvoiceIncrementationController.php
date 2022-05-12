<?php

namespace App\Controller;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceIncrementationController extends AbstractController
{

    public function __invoke(Invoice $data, EntityManagerInterface $em)
    {

        $data->setChrono($data->getChrono() + 1);
        $em->flush();
        return $data;
    }


}
