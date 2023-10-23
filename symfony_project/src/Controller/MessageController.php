<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
   #[Route('/message/id/', name: "get_message", methods: ["GET"])]
    public function getMessage(string $id, string $name) {
        $message = new MessageEntityRepository();
        $data = $message->getOne($id,$name);
        $this->renderJSON($data);
    }
    #[Route('/message', name: "post_message", methods: ["POST"])]
    public function postMessage(string $id) {
        $message = new MessageEntityRepository();
        $data = $message->postOne($id,$name);
        $this->renderJSON($data);
    }
    #[Route('/message/{id}', name: "delete_message", methods: ["DELETE"])]
    public function deleteMessage(string $id) {
        $message= new MessageEntityRepository();
        $message->deleteOne($id);
    }
    #[Route('/message/user/{id}', name: "get_message_by_user", methods: ["GET"])]
    public function getMessageByUser(string $id) {
        $message = new MessageEntityRepository();
        $data = $message->getByUser($id);
        $this->renderJSON($data);
    }
    #[Route('/message/conversation/{id}', name: "get_message_by_conversation", methods: ["GET"])]
    public function getMessageByConversation(string $id) {
        $message = new MessageEntityRepository();
        $data = $message->getByConversation($id);
        $this->renderJSON($data);
    }
}
