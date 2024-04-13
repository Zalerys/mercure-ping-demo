<?php

// namespace App\Controller;

// use App\Entity\User;
// use App\Entity\Message;
// use App\Entity\Conversation;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Mercure\HubInterface;
// use Symfony\Component\Mercure\Update;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Validator\Validator\ValidatorInterface;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;

// class MessageControllerAled extends AbstractController
// {
//     private $entityManager;
//     private $hub;
//     private $validator;

//     public function __construct(EntityManagerInterface $entityManager, HubInterface $hub)
//     {
//         $this->entityManager = $entityManager;
//         $this->hub = $hub;
//         // $this->validator = $validator;
//     }

//     // #[Route('/send-message/{user}', name: 'send_message_to_user', methods: 'POST')]
//     // public function sendMessageToUser(
//     //     Request $request,
//     //     User $user
//     // ): JsonResponse {
//     //     $data = json_decode($request->getContent(), true);

//     //     // Validation des données
//     //     if (!$data || !isset($data['content']) || !isset($data['conversation_id'])) {
//     //         return $this->json(['error' => 'Message invalide'], 400);
//     //     }

//     //     // Création du message
//     //     $messageContent = $data['content'];
//     //     $conversationId = $data['conversation_id'];

//     //     $message = $this->createAndPersistMessage($messageContent, $user, $conversationId);

//     //     // Envoi du message à l'utilisateur spécifié
//     //     $this->publishMessageToUser($user, $message);

//     //     return $this->json(['message' => 'Message envoyé avec succès']);
//     // }

//     // #[Route('/send-message-to-all', name: 'send_message_to_all', methods: 'POST')]
//     // public function sendMessageToAll(Request $request): JsonResponse
//     // {
//     //     $data = json_decode($request->getContent(), true);

//     //     // Validation des données
//     //     if (!$data || !isset($data['content'])) {
//     //         return $this->json(['error' => 'Message invalide'], 400);
//     //     }

//     //     // Création du message
//     //     $messageContent = $data['content'];

//     //     // Enregistrement du message dans la base de données
//     //     $message = $this->createAndPersistMessage($messageContent, null, null);

//     //     // Envoi du message à tous les utilisateurs
//     //     $this->publishMessageToAll($message);

//     //     return $this->json(['message' => 'Message envoyé à tout le monde avec succès']);
//     // }

//     private function createAndPersistMessage(string $content, ?User $sender, ?int $conversationId): Message
//     {
//         // Si une conversation est spécifiée, on l'associe au message
//         if ($conversationId) {
//             $conversation = $this->entityManager->getRepository(Conversation::class)->find($conversationId);

//             if (!$conversation) {
//                 throw $this->createNotFoundException('Conversation non trouvée');
//             }
//         } else {
//             $conversation = null;
//         }

//         // Création d'une nouvelle instance de Message
//         $message = new Message();
//         $message->setContent($content);
//         $message->setSender($sender);
//         $message->setConversation($conversation);

//         // Enregistrement du message dans la base de données
//         $this->entityManager->persist($message);
//         $this->entityManager->flush();

//         return $message;
//     }

//     private function publishMessageToUser(User $user, Message $message): void
//     {
//         $update = new Update(
//             [
//                 "https://example.com/my-private-topic",
//                 "https://example.com/user/{$user->getId()}/?topic=" . urlencode("https://example.com/my-private-topic"),
//             ],
//             json_encode(['content' => $message->getContent()]),
//             true
//         );

//         $this->hub->publish($update);
//     }

//     private function publishMessageToAll(Message $message): void
//     {
//         $publicUpdate = new Update(
//             'https://example.com/my-public-message-all',
//             json_encode(['message' => $message->getContent()])
//         );

//         $this->hub->publish($publicUpdate);
//     }
// }
