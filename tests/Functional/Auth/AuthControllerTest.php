<?php

declare(strict_types=1);

namespace App\Tests\Functional\Auth;

use App\Tests\Functional\FunctionnalTestCase; // 💡 On importe ta classe intermédiaire
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class AuthControllerTest extends FunctionnalTestCase
{
    // Test de la page de login avec une connexion réussie
    public function testThatLoginShouldSucceeded(): void
    {
        $this->get('/login');

        // On utilise $this->client hérité de ta classe parente pour soumettre le formulaire
        $this->client->submitForm('Connexion', [
            '_username' => 'Admin',
            '_password' => 'adminpassword'
        ]);

        $authorizationChecker = $this->service(AuthorizationCheckerInterface::class);

        self::assertTrue($authorizationChecker->isGranted('IS_AUTHENTICATED'));
    }

    // Test de la page de login avec une connexion échouée
    public function testThatLoginShouldFailed(): void
    {
        $this->get('/login');

        $this->client->submitForm('Connexion', [
            '_username' => 'unknowuser@email.com',
            '_password' => 'errormdp'
        ]);

        $authorizationChecker = $this->service(AuthorizationCheckerInterface::class);

        self::assertFalse($authorizationChecker->isGranted('IS_AUTHENTICATED'));
    }
}