<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Factory\ConversationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(10);
        $users = $manager->getRepository(User::class)->findAll();

        ConversationFactory::new(function() use ($users) {
            return [
                'participants' => $users
            ];
        })->create();
    }
}
