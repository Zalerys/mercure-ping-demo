<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Conversation;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;




class MessageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/send-message/{user}', name: 'send_message_to_user', methods: 'POST')]
    public function sendMessageToUser(Request $request, User $user, HubInterface $hub)
    {
        $data = json_decode($request->getContent(), true);


        if (!$data || !isset($data['content']) || !isset($data['conversation_id'])) {
            return $this->json(['error' => 'Message invalide'], 400);
        }

        $message = [
            'message' => $data['content'],
        ];
        $messageContent = $data['content'];
        $conversationId = $data['conversation_id'];
        $currentUser = $data['currentUser'];
        $messageDB = $this->createAndPersistMessage($messageContent, $user, $conversationId);


        $update = new Update(
            [
                "https://example.com/my-private-topic",
                "https://example.com/user/{$user->getId()}/?topic=" . urlencode("https://example.com/my-private-topic")
            ],
            json_encode([
                'content' => $message,
                'user' => $user->getId(),
                'currentUser' => $currentUser
            ]),
            true
        );


        $hub->publish($update);

        return $this->json([
            'message' => 'Message envoyé avec succès'
        ]);
    }

    #[Route('/send-message-to-all', name: 'send_message_to_all', methods: 'POST')]
    public function sendMessageToAll(Request $request, HubInterface $hub)
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['content'])) {
            return $this->json([
                'error' => 'Message invalide'
            ], 400);
        }

        $message = [
            'message' => $data['content'],
        ];

        $publicUpdate = new Update(
            'https://example.com/my-public-message-all',
            json_encode(['message' => $message])
        );

        $hub->publish($publicUpdate);

        return $this->json([
            'message' => 'Message envoyé à tout le monde avec succès'
        ]);
    }



    #[Route('/get-last-messages/{conversation}', name: 'get-last-messages', methods: 'GET')]
    public function getLastMessages(Conversation $conversation)
    {
        if (!$conversation instanceof Conversation) {
            return $this->json([
                'error' => 'Conversation non trouvée'
            ], 404);
        }

        $messages = $this->entityManager->getRepository(Message::class)
            ->findBy(['conversation' => $conversation->getId()], null, 50);

        $formattedMessages = [];
        foreach ($messages as $message) {
            $formattedMessages[] = [
                'content' => $message->getContent(),
                'sender' => $message->getSender() ? $message->getSender()->getUsername() : 'Unknown',
            ];
        }

        return $this->json($formattedMessages);
    }




    private function createAndPersistMessage(string $content, ?User $sender, ?int $conversationId): Message
    {
        // Si une conversation est spécifiée, on l'associe au message
        if ($conversationId) {
            $conversation = $this->entityManager->getRepository(Conversation::class)->find($conversationId);

            if (!$conversation) {
                throw $this->createNotFoundException('Conversation non trouvée');
            }
        } else {
            $conversation = null;
        }

        // Création d'une nouvelle instance de Message
        $message = new Message();
        $message->setContent($content);
        $message->setSender($sender);
        $message->setConversation($conversation);

        // Enregistrement du message dans la base de données
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }
}




