<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Participant;
use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe;

class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    }


    #[Route('/stripe/create-charge/{id}', name: 'app_stripe_charge', methods: ['GET', 'POST'])]
    public function createCharge(Request $request, Campaign $campaign, EntityManagerInterface $entityManager)
    {
        $payment = new Payment();
        $participant = new Participant();

        $participant->setName($request->request->get('name'));
        $participant->setEmail($request->request->get('email'));
        $participant->setCampaign($campaign);

        $payment->setAmount($request->request->get('amount'));
        $payment->setParticipant($participant);

        $entityManager->persist($participant);
        $entityManager->persist($payment);
        $entityManager->flush();

        $amount = $payment->getAmount() * 100;


        try {
            Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
            $token = $request->request->get('stripeToken');
            $stripeToken = Stripe\Token::retrieve($token);
            Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "usd",
                'description' => 'Example charge',
                'source' => $stripeToken
            ]);
        } catch (Stripe\Exception\InvalidRequestException $e) {
            dd($e);
        }


        $this->addFlash(
            'success',
            'Payment Successful!'
        );
        return $this->redirectToRoute('app_campaign_show', [
            'id' => $campaign->getId(),
        ], Response::HTTP_SEE_OTHER);
    }
}
