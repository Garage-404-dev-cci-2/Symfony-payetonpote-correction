<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/campaign_v1/create', name: 'create_campaign')]
    public function createCampaign(): Response
    {
        return $this->render('campaign_v1/create.html.twig', []);
    }

    #[Route('/campaign_v1/show', name: 'show_campaign')]
    public function showCampaign(): Response
    {
        return $this->render('campaign_v1/show.html.twig', []);
    }

    #[Route('/payment/create', name: 'create_payment')]
    public function createPayment(): Response
    {
        return $this->render('payment/create.html.twig', []);
    }
}
