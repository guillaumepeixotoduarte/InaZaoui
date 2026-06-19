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
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2.page-title', 'Invités'); 

        $expectedUserCount = $this->service(UserRepository::class)->count([]);
        $expectedOnPage = min($expectedUserCount, 25);

        $this->assertSelectorCount($expectedOnPage, '.admin-user-table tbody tr');
    }

    /**
     * Vérification que l'ajout d'un invité fonctionne
     */
    public function testAddUserAsAdmin(): void
    {
        $this->login();

        $crawler = $this->get('/admin/invite/add');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[name]'] = 'Add Test';
        $form['user[description]'] = 'Add Test Description';
        $form['user[email]'] = 'addtest@test.com';
        $form['user[password][first]'] = 'password123';
        $form['user[password][second]'] = 'password123';
        $form['user[active]'] = '1';

        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/invite');
    }

    /**
     * Vérification que le bouton qui désactive un invité fonctionne
     */
    public function testDesactivateUser(){

        $this->login();

        $crawler = $this->get('/admin/invite');
        $this->assertResponseIsSuccessful();

        $userRepository = $this->service(UserRepository::class);
        $classicUser = $userRepository->findOneBy(['admin' => false]);
        $classicUserId = $classicUser->getId();
        $userAccess = $classicUser->isActive();

        $link = $crawler->filter(sprintf('a[href="/admin/invite/switch_access/%d"]', $classicUserId))->link();

        $this->client->click($link);
        $this->assertResponseRedirects('/admin/invite');
        $this->getEntityManager()->clear();

        $AfterChangeUser = $userRepository->findOneBy(['id' => $classicUserId]);

        $this->assertNotEquals($userAccess, $AfterChangeUser->isActive(), 'Le statut de l\'utilisateur n\'a pas été inversé en BDD.');
    }

    /**
     * Vérification que la suppression d'un invité fonctionne
     */
    public function testDeleteUserAsAdmin(): void
    {
        $this->login();

        $userRepository = $this->service(UserRepository::class);
        $userToDelete = $userRepository->findOneBy(['admin' => false], ['id' => 'ASC']);
        $albumId = $userToDelete->getId();
        self::assertNotNull($userToDelete, 'Il faut au moins un album dans les fixtures pour ce test.');

        $this->get('/admin/invite/delete/' . $albumId);

        $this->assertResponseRedirects('/admin/invite');

        $this->getEntityManager()->clear();
        $deletedUser = $userRepository->find($albumId);
        self::assertNull($deletedUser, 'L\'album n\'a pas été supprimé de la base de données.');
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

        $this->assertResponseRedirects('/login'); 

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
        $this->login($userLogin->getEmail()); 

        $userRepository = $this->service(UserRepository::class);
        $classicUser = $userRepository->findOneBy(['admin' => false], ['id' => 'DESC']);
        
        self::assertNotNull($classicUser, 'Il faut un utilisateur en BDD pour tenter la suppression.');
        $classicUserId = $classicUser->getId();
        
        // Tentative d'accès avec le rôle Invité
        $this->get(sprintf('/admin/invite/delete/%d', $classicUserId));

        // 💡 Devrait renvoyer un code 403 Access Denied (Interdit)
        $this->assertResponseStatusCodeSame(403); 

        $this->getEntityManager()->clear();

        // Vérification que l'utilisateur n'est pas supprimé
        $userAfterAttempt = $userRepository->find($classicUserId);
        self::assertNotNull($userAfterAttempt, "L'utilisateur n'aurait pas dû être supprimé par un simple invité.");
    }

}