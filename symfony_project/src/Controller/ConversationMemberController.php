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

    #[Route('/conversation/member/user/{id}', name: "get_conversation_member_by_user", methods: ["GET"])]
    public function getConversationMemberByUser(string $id) {
        $conversation_member= new ConversationMemberEntityRepository();
        $data = $conversation_member->getByUser($id);
        $this->renderJSON($data);
    }
    #[Route('/conversation/member/{id}', name: "get_conversation_member_by_conversation", methods: ["GET"])]
    public function getConversationMemberByConversation(string $id) {
        $conversation_member = new ConversationMemberEntityRepository();
        $data = $conversation_member->getByConversation($id);
        $this->renderJSON($data);
    }
    #[Route('/conversation/id/', name: "get_conversation_member", methods: ["GET"])]
    public function getConversationMember(string $id) {
        $conversation_member = new ConversationMemberEntityRepository();
        $data = $conversation_member->getOne($id);
        $this->renderJSON($data);
    }
}
