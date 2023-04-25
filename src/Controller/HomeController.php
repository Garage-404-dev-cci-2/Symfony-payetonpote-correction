<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Campaign;
use App\Entity\Participant;
use App\Entity\Payment;
use App\Form\CampaignType;

class HomeController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $campaigns = $entityManager
            ->getRepository(Campaign::class)
            ->findAll();

        


        return $this->render('home/index.html.twig', [
            'campaigns' => $campaigns,
        ]);
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
