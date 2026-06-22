<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Tests\Functional\FunctionnalTestCase;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserControllerTest extends FunctionnalTestCase
{
    /**
     * Vérification de la page qui affiche la liste des utilisateurs
     */
    public function testListAdminUsersAsAdmin(): void
    {
        $this->login();

        $this->get('/admin/invite');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h2.page-title', 'Invités'); 

        $expectedUserCount = $this->service(UserRepository::class)->count([]);
        $expectedOnPage = min($expectedUserCount, 25);

        self::assertSelectorCount($expectedOnPage, '.admin-user-table tbody tr');
    }

    /**
     * Vérification que l'ajout d'un invité fonctionne
     */
    public function testAddUserAsAdmin(): void
    {
        $this->login();

        $crawler = $this->get('/admin/invite/add');
        self::assertResponseIsSuccessful();

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[name]'] = 'Add Test';
        $form['user[description]'] = 'Add Test Description';
        $form['user[email]'] = 'addtest@test.com';
        $form['user[password][first]'] = 'password123';
        $form['user[password][second]'] = 'password123';
        $form['user[active]'] = '1';

        $this->client->submit($form);

        self::assertResponseRedirects('/admin/invite');

        $userRepository = $this->service(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'addtest@test.com']);

        self::assertNotNull($user, "L'utilisateur n'a pas été enregistré en base de données.");

        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Vérification que le bouton qui désactive un invité fonctionne
     */
    public function testDesactivateUser(): void
    {

        $this->login();

        $crawler = $this->get('/admin/invite');
        self::assertResponseIsSuccessful();

        $userRepository = $this->service(UserRepository::class);
        $classicUser = $userRepository->findOneBy(['admin' => false]);

        self::assertNotNull($classicUser, "Aucun utilisateur classique trouvé pour ce test.");

        $classicUserId = $classicUser->getId();
        $userAccess = $classicUser->isActive();

        $link = $crawler->filter(sprintf('a[href="/admin/invite/switch_access/%d"]', $classicUserId))->link();

        $this->client->click($link);
        self::assertResponseRedirects('/admin/invite');
        $this->getEntityManager()->clear();

        $AfterChangeUser = $userRepository->findOneBy(['id' => $classicUserId]);

        self::assertNotNull($AfterChangeUser, "L'utilisateur doit exister en BDD.");

        self::assertNotEquals($userAccess, $AfterChangeUser->isActive(), 'Le statut de l\'utilisateur n\'a pas été inversé en BDD.');
    }

    /**
     * Vérification que la suppression d'un invité fonctionne
     */
    public function testDeleteUserAsAdmin(): void
    {
        $this->login();

        $userRepository = $this->service(UserRepository::class);
        $userToDelete = $userRepository->findOneBy(['admin' => false], ['id' => 'ASC']);
        self::assertNotNull($userToDelete, "L'utilisateur doit exister en BDD.");
        $albumId = $userToDelete->getId();

        $this->get('/admin/invite/delete/' . $albumId);

        self::assertResponseRedirects('/admin/invite');

        $this->getEntityManager()->clear();
        $deletedUser = $userRepository->find($albumId);
        self::assertNull($deletedUser, 'L\'utilisateur n\'a pas été supprimé de la base de données.');
    }

    /**
     * Vérification que si on essaye de supprimer un invité sans être connecté ne fonctionne pas
     */
    public function testDeleteUserWithoutLogin(): void
    {
        $userRepository = $this->service(UserRepository::class);
        $classicUser = $userRepository->findOneBy(['admin' => false]);
        
        self::assertNotNull($classicUser, 'Il faut un utilisateur en BDD pour tenter la suppression.');
        $classicUserId = $classicUser->getId();
        $this->get(sprintf('/admin/invite/delete/%d', $classicUserId));

        self::assertResponseRedirects('/login'); 

        $this->getEntityManager()->clear();

        $userAfterAttempt = $userRepository->find($classicUserId);
        self::assertNotNull($userAfterAttempt, "L'utilisateur n'aurait pas dû être supprimé car l'accès n'était pas connecté.");
    }

    /**
     * Vérification que si on essaye de supprimer un invité avec un autre invité ne fonctionne pas
     */
    public function testDeleteUserAsGuestFails(): void
    {

        $userRepository = $this->service(UserRepository::class);
        $userLogin = $userRepository->findOneBy(['admin' => false]);
        self::assertNotNull($userLogin, 'Il faut un utilisateur en BDD pour tenter la suppression.');
        $this->login((string) $userLogin->getEmail()); 

        $userRepository = $this->service(UserRepository::class);
        $classicUser = $userRepository->findOneBy(['admin' => false], ['id' => 'DESC']);
        
        self::assertNotNull($classicUser, 'Il faut un utilisateur en BDD pour tenter la suppression.');
        $classicUserId = $classicUser->getId();
        
        // Tentative d'accès avec le rôle Invité
        $this->get(sprintf('/admin/invite/delete/%d', $classicUserId));

        // 💡 Devrait renvoyer un code 403 Access Denied (Interdit)
        self::assertResponseStatusCodeSame(403); 

        $this->getEntityManager()->clear();

        // Vérification que l'utilisateur n'est pas supprimé
        $userAfterAttempt = $userRepository->find($classicUserId);
        self::assertNotNull($userAfterAttempt, "L'utilisateur n'aurait pas dû être supprimé par un simple invité.");
    }

    /**
     * Vérifie qu'un compte désactivé au hasard est bloqué à la connexion, puis débloqué une fois réactivé.
     */
    public function testDisabledUserLoginWorkflow(): void
    {
        $userRepository = $this->service(UserRepository::class);
        $em = $this->getEntityManager(); 

        // 1. On récupère un utilisateur classique au hasard
        $user = $userRepository->findOneBy(['admin' => false]);
        self::assertNotNull($user, "Il faut un utilisateur en BDD pour exécuter ce test.");
        $userName = $user->getName();

        // 2. On le passe à actif = false (désactivé)
        $user->setActive(false); // Ajuste selon le nom de ton setter (ex: setActive(0))
        $em->flush();
        $em->clear();

        // 3. Tentative de connexion -> Doit échouer
        $crawler = $this->get('/login');
        $form = $crawler->selectButton('Connexion')->form(); // Ajuste le texte de ton bouton
        $this->client->submit($form, [
            '_username' => $userName,
            '_password' => 'password123', // Utilise le mot de passe standard de tes fixtures
        ]);

        self::assertResponseRedirects('/login');
        $crawler = $this->client->followRedirect();
        self::assertSelectorTextContains('.alert', 'Votre compte est désactivé. Connexion impossible.');

        // 4. On le repasse en normal (actif = true)
        $user = $userRepository->findOneBy(['name' => $userName]);
        self::assertNotNull($user, "Il faut un utilisateur en BDD pour exécuter ce test.");
        $user->setActive(true);
        $em->flush();
        $em->clear();

        // 5. Nouvelle tentative de connexion -> Doit réussir
        $crawler = $this->get('/login');
        $form = $crawler->selectButton('Connexion')->form();
        $this->client->submit($form, [
            '_username' => $userName,
            '_password' => 'password123',
        ]);

        // Redirection vers la page d'accueil ou tableau de bord après succès
        self::assertResponseRedirects('/'); 
    }

    /**
     * Vérifie qu'un utilisateur classique modifié temporairement avec la colonne admin à true 
     * mais sans le ROLE_ADMIN récupère automatiquement son rôle lors de sa connexion.
     */
    public function testAdminColumnSynchronizesRoleOnLogin(): void
    {
        $userRepository = $this->service(UserRepository::class);
        $em = $this->getEntityManager();

        // 1. On récupère un utilisateur lambda (pas admin)
        $user = $userRepository->findOneBy(['admin' => false]);
        self::assertNotNull($user, "Il faut un utilisateur classique en BDD pour exécuter ce test.");
        $userName = $user->getName();

        // On sauvegarde ses rôles d'origine pour pouvoir les remettre à la fin
        $originalRoles = $user->getRoles();

        try {
            // 2. On le transforme en "admin corrompu" : colonne à true, mais pas de ROLE_ADMIN
            $user->setAdmin(true); // Ajuste selon ton setter
            $user->setRoles([]);   // On s'assure qu'il n'a aucun rôle admin
            $em->flush();
            $em->clear();

            // 3. Tentative de connexion
            $crawler = $this->get('/login');
            $form = $crawler->selectButton('Connexion')->form();
            $this->client->submit($form, [
                '_username' => $userName,
                '_password' => 'password123', // Ton mot de passe de fixtures
            ]);

            self::assertResponseRedirects('');
            $em->clear();

            // On récupère à nouveau notre utilisateur pour vérifier si le role a bien été rajouté
            $userAfterLogin = $userRepository->findOneBy(['name' => $userName]);
            self::assertNotNull($userAfterLogin, "Il faut un utilisateur en BDD pour exécuter ce test.");
            self::assertContains(
                'ROLE_ADMIN', 
                $userAfterLogin->getRoles(), 
                "Le rôle ROLE_ADMIN aurait dû être ajouté automatiquement car la colonne admin est à true."
            );

        } finally {
            $this->client->restart();
            
            $userReset = $userRepository->findOneBy(['name' => $userName]);
            if ($userReset !== null) {
                $userReset->setAdmin(false);
                $userReset->setRoles($originalRoles);
                $em->flush();
                $em->clear();
            }
        }
    }

}