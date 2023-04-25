<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Payment;
use App\Form\PaymentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'app_payment_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $payments = $entityManager
            ->getRepository(Payment::class)
            ->findAll();

        return $this->render('payment/index.html.twig', [
            'payments' => $payments,
        ]);
    }

    #[Route('/new/{id}', name: 'app_payment_new', methods: ['GET', 'POST'])]
    public function new(Campaign $campaign): Response
    {

        return $this->render('payment/new.html.twig', [
            'campaign' => $campaign,
        ]);
    }
}
