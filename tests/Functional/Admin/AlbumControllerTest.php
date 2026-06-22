<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Tests\Functional\FunctionnalTestCase;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AlbumControllerTest extends FunctionnalTestCase
{
    /**
     * Vérification de la page qui liste les albums
     */
    public function testListAdminMediaAsAdmin(): void
    {
        $this->login();

        $this->get('/admin/album');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2.page-title', 'Albums'); 

        $expectedMediaCount = $this->service(AlbumRepository::class)->count([]);

        $this->assertSelectorCount($expectedMediaCount, '.admin-album-table tbody tr');
    }

    /**
     * Vérification de l'ajout d'un album
     */
    public function testAddAlbumAsAdmin(): void
    {
        $this->login();

        $crawler = $this->get('/admin/album/add');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Ajouter')->form();
        $form['album[name]'] = 'Mon nouvel album de test';

        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/album');

        $albumRepository = $this->service(AlbumRepository::class);
        $addedAlbum = $albumRepository->findOneBy(['name' => 'Mon nouvel album de test']);
        self::assertNotNull($addedAlbum, 'L\'album n\'a pas été ajouté en base de données.');
    }

    /**
     * Vérification de la modification du nom d'un album
     */
    public function testUpdateAlbumAsAdmin(): void
    {
        $this->login();

        $albumRepository = $this->service(AlbumRepository::class);
        $albumToUpdate = $albumRepository->findOneBy([], ['id' => 'ASC']);
        self::assertNotNull($albumToUpdate, 'Il faut au moins un album dans les fixtures pour ce test.');

        $crawler = $this->get('/admin/album/update/' . $albumToUpdate->getId());
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form();
        $form['album[name]'] = 'Nom mis à jour de l\'album';

        $this->client->submit($form);

        $this->assertResponseRedirects('/admin/album');

        // Rafraîchir l'entité depuis la base de données
        $updatedAlbum = $albumRepository->find($albumToUpdate->getId());
        self::assertNotNull($updatedAlbum, 'Il faut au moins un album dans les fixtures pour ce test.');
        self::assertEquals('Nom mis à jour de l\'album', $updatedAlbum->getName(), 'Le nom de l\'album n\'a pas été mis à jour en base de données.');
    }

    /**
     * Vérification de la suppression d'un album
     */
    public function testDeleteAlbumAsAdmin(): void
    {
        $this->login();

        $albumRepository = $this->service(AlbumRepository::class);
        $albumToDelete = $albumRepository->findOneBy([], ['id' => 'ASC']);
        self::assertNotNull($albumToDelete, 'Il faut au moins un album dans les fixtures pour ce test.');
        $albumId = $albumToDelete->getId();

        $this->get('/admin/album/delete/' . $albumId);

        $this->assertResponseRedirects('/admin/album');

        $this->getEntityManager()->clear();
        $deletedAlbum = $albumRepository->find($albumId);
        self::assertNull($deletedAlbum, 'L\'album n\'a pas été supprimé de la base de données.');
    }

}