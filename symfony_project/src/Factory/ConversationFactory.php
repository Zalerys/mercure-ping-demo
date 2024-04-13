<?php

namespace App\Factory;

use App\Entity\Conversation;
use App\Entity\User;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Conversation>
 *
 * @method static Conversation|Proxy createOne(array $attributes = [])
 * @method static Conversation[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Conversation|Proxy find(object|array|mixed $criteria)
 * @method static Conversation|Proxy findOrCreate(array $attributes)
 * @method static Conversation|Proxy first(string $sortedField = 'id')
 * @method static Conversation|Proxy last(string $sortedField = 'id')
 * @method static Conversation|Proxy random(array $attributes = [])
 * @method static Conversation|Proxy randomOrCreate(array $attributes = [])
 * @method static Conversation[]|Proxy[] all()
 * @method static Conversation[]|Proxy[] findBy(array $attributes)
 * @method static Conversation[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Conversation[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 */
final class ConversationFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            // Participants par défaut est un tableau vide
            'participants' => []
        ];
    }

    protected static function getClass(): string
    {
        return Conversation::class;
    }

    // Ajoutez une méthode pour permettre de spécifier les participants lors de la création
    public function withParticipants(array $participants): self
    {
        return $this->addState(['participants' => $participants]);
    }
}
