<?php

declare(strict_types=1);

namespace App\Tests\Functional\Front;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\MediaRepository;
use App\Repository\AlbumRepository;
use App\Tests\Functional\FunctionnalTestCase;

class HomeControllerTest extends FunctionnalTestCase
{
    // Test que la page d'accueil répond
    public function testHomepageIsUpAndRunning(): void
    {
        $this->get('/');

        // 1. On s'assure que la page ne renvoie pas une erreur 500 ou 404
        $this->assertResponseIsSuccessful(); // Code 200

        // 2. On vérifie que le titre "Photographe" est bien présent dans la page
        $this->assertSelectorTextContains('h2', 'Photographe'); 
    }

    // Test que la page des invités répond et affiche le bon nombre d'invités
    public function testGuestsPageIsUpAndRunning(): void
    {
        $this->get('/guests');
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h3', 'Invités'); 

        $totalGuestsInDb = $this->service(UserRepository::class)->count(['admin' => false]);
        
        $this->assertSelectorCount($totalGuestsInDb, '.guests .guest');
    }

    // Test que lorsqu'on clique sur un invité, on est redirigé vers sa page et que le nombre d'images affichées correspond au nombre d'images de cet invité
    public function testClickOnGuestDisplaysCorrectNumberOfImages(): void
    {
        $crawler = $this->get('/guests');
        $this->assertResponseIsSuccessful();

        $link = $crawler->filter('.guests .guest a')->first()->link();
        $this->client->click($link);
        $this->assertResponseIsSuccessful();

        /** @var User $firstGuest */
        $firstGuest = $this->service(UserRepository::class)->findOneBy(['admin' => false], ['id' => 'ASC']);
        $expectedMediaCount = $this->service(MediaRepository::class)->count(['user' => $firstGuest]);

        $this->assertSelectorTextContains('h3', $firstGuest->getName());
        $this->assertSelectorCount($expectedMediaCount, '.media-list .media');
    }

    public function testPortfolioPageIsUpAndAlbumFiltering(): void
    {
        $crawler = $this->get('/portfolio');
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h3', 'Portfolio'); 

        $mediaRepository = $this->service(MediaRepository::class);
        $adminUser = $this->service(UserRepository::class)->findOneBy(['admin' => true]);
        
        $expectedMediaCount = $mediaRepository->count(['user' => $adminUser]);
        $expectedAlbumCount = $this->service(AlbumRepository::class)->count([]);

        $this->assertSelectorCount($expectedMediaCount, '.media-list .media');

        // Test bon nombre d'albums affichés
        $this->assertSelectorCount($expectedAlbumCount, '.album-filter-list .album-filter');

        // Test Clique sur un album et vérifie que le nombre d'images affichées correspond au nombre d'images de cet album
        $link = $crawler->filter('.album-filter-list .album-filter a')->first()->link();
        $this->client->click($link);

        $firstAlbum = $this->service(AlbumRepository::class)->findOneBy([], ['id' => 'ASC']);
        $expectedMediaCountInAlbum = $mediaRepository->count(['album' => $firstAlbum]);

        $this->assertSelectorCount($expectedMediaCountInAlbum, '.media-list .media');
    }
}