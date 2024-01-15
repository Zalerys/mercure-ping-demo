<?php
namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConversationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/conversation/create', name: 'create_conversation', methods: 'POST')]
    public function createConversation(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['users']) || !is_array($data['users'])) {
            return $this->json([
                'error' => 'Données de conversation invalides'
            ], 400);
        }

        $userRepository = $this->entityManager->getRepository(User::class);
        $users = [];
        foreach ($data['users'] as $userId) {
            $user = $userRepository->find($userId);
            if (!$user instanceof User) {
                return $this->json([
                    'error' => 'Utilisateur introuvable avec l\'ID ' . $userId
                ], 404);
            }
            $users[] = $user;
        }

        $existingConversation = $this->findExistingConversation($users);
        if ($existingConversation) {
            return $this->json([
                'message' => 'Conversation existante',
                'conversation_id' => $existingConversation->getId()
            ]);
        }        

        $conversation = new Conversation();
        foreach ($users as $user) {
            $conversation->addParticipant($user);
        }

        $this->entityManager->persist($conversation);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Conversation créée avec succès',
            'conversation_id' => $conversation->getId()
        ]);
    }

    #[Route('/conversation/{conversationId}', name: 'get_conversation', methods: 'GET')]
    public function getConversation(Conversation $conversation)
    {
        if (!$conversation instanceof Conversation) {
            return $this->json([
                'error' => 'Conversation non trouvée'
            ], 404);
        }

        $participants = [];
        foreach ($conversation->getParticipants() as $participant) {
            $participants[] = [
                'id' => $participant->getId(),
                'username' => $participant->getUsername(),
            ];
        }

        return $this->json([
            'conversation_id' => $conversation->getId(),
            'participants' => $participants,
        ]);
    }
        private function findExistingConversation(array $users): ?Conversation
    {
        $conversationRepository = $this->entityManager->getRepository(Conversation::class);
        $conversations = $conversationRepository->findAll();

        foreach ($conversations as $conversation) {
            $participants = $conversation->getParticipants()->toArray();

            if (count($participants) === count($users) && $this->arrayContainsSameElements($participants, $users)) {
                return $conversation; 
            }
        }

        return null; 
    }

    private function arrayContainsSameElements(array $array1, array $array2): bool
    {
        sort($array1);
        sort($array2);
        return $array1 === $array2;
    }

}


