<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    // 2. On injecte le service via le constructeur
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setName('Admin');
        $user->setDescription('Administrateur du site');
        $user->setAdmin(true);
        $user->setEmail('admin@test.com');
        $user->setPassword(($this->passwordHasher->hashPassword($user, 'adminpassword')));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setActive(true);

        $manager->persist($user);

        $this->addReference('user_admin', $user);

        // On crée une boucle pour insérer exactement 10 invités de test
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setName('Invité ' . $i);
            $user->setDescription('Description de l\'invité ' . $i);
            $user->setAdmin(false);
            $user->setEmail('guest' . $i . '@test.com');
            $user->setPassword(($this->passwordHasher->hashPassword($user, 'password123')));
            $user->setActive(true);
            
            $manager->persist($user);

            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}