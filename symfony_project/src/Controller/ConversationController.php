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
        // Vérifier si la conversation existe
        if (!$conversation instanceof Conversation) {
            return $this->json([
                'error' => 'Conversation non trouvée'
            ], 404);
        }

        // Récupérer les détails de la conversation
        $participants = [];
        foreach ($conversation->getParticipants() as $participant) {
            $participants[] = [
                'id' => $participant->getId(),
                'username' => $participant->getUsername(),
                // Ajoute d'autres détails si nécessaire
            ];
        }

        return $this->json([
            'conversation_id' => $conversation->getId(),
            'participants' => $participants,
            // Ajoute d'autres détails de conversation si nécessaire
        ]);
    }
        private function findExistingConversation(array $users): ?Conversation
    {
        // On va chercher une conversation qui a exactement les mêmes participants
        $conversationRepository = $this->entityManager->getRepository(Conversation::class);

        // Récupérer toutes les conversations
        $conversations = $conversationRepository->findAll();

        foreach ($conversations as $conversation) {
            // Récupérer les participants de la conversation actuelle
            $participants = $conversation->getParticipants()->toArray();

            // Vérifier si les participants de la conversation correspondent exactement
            if (count($participants) === count($users) && $this->arrayContainsSameElements($participants, $users)) {
                return $conversation; // Retourner la conversation existante
            }
        }

        return null; // Aucune conversation trouvée avec les mêmes participants
    }

    // Méthode pour vérifier si deux tableaux ont les mêmes éléments, peu importe l'ordre
    private function arrayContainsSameElements(array $array1, array $array2): bool
    {
        sort($array1);
        sort($array2);
        return $array1 === $array2;
    }

}


