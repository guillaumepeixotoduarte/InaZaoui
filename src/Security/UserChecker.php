<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function checkPreAuth(UserInterface $user): void
    {
        // Rien à faire avant la validation du mot de passe
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        // Si compte désactiver
        if (!$user->isActive()) {
            throw new CustomUserMessageAuthenticationException(
                'Votre compte est désactivé. Connexion impossible.'
            );
        }

        // Ajout du Role Admin si il le ne le possède pas encore et que la colonne admin est a true
        if ($user->isAdmin()) {
            $roles = $user->getRoles();
            
            if (!in_array('ROLE_ADMIN', $roles, true)) {
                $roles[] = 'ROLE_ADMIN';
                $user->setRoles($roles);

                $this->entityManager->flush();
            }
        }
    }
}