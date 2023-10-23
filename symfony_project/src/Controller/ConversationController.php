<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConversationController extends AbstractController
{
    #[Route('/conversation/id/', name: "get_conversation", methods: ["GET"])]
    public function getConversation(string $id, string $name) {
        $conversation = new ConversationEntityRepository();
        $data = $conversation->getOne($id,$name);
        $this->renderJSON($data);
    }
    #[Route('/conversation', name: "post_conversation", methods: ["POST"])]
    public function postConversation(string $id) {
        $conversation = new ConversationEntityRepository();
        $data = $conversation->postOne($id,$name);
        $this->renderJSON($data);
    }
    #[Route('/conversation/{id}', name: "delete_conversation", methods: ["DELETE"])]
    public function deleteConversation(string $id) {
        $conversation= new ConversationEntityRepository();
        $conversation->deleteOne($id);
    }

}
