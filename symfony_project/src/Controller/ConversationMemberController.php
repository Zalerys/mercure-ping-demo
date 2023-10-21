<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConversationMemberController extends AbstractController
{
    #[Route('/conversation/member', name: 'conversation_member')]
    public function index(): Response
    {
        return $this->render('conversation_member/index.html.twig', [
            'controller_name' => 'ConversationMemberController',
        ]);
    }
}
