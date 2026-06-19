<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Tests\Functional\FunctionnalTestCase;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// 💡 Plus besoin de "use App\Tests\FunctionalTestCase;" si le fichier de base est bien à la racine du dossier tests/
class MediaControllerTest extends FunctionnalTestCase
{
    /**
     * Vérification de la page qui liste les medias en tant qu'admin
     */
    public function testListAdminMediaAsAdmin(): void
    {
        $this->login();

        $this->get('/admin/media');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2.page-title', 'Medias'); 

        $expectedMediaCount = $this->service(MediaRepository::class)->count([]);
        $expectedOnPage = min($expectedMediaCount, 25);

        $this->assertSelectorCount($expectedOnPage, '.admin-media-table tbody tr');
    }

    /**
     * Vérification de la page qui liste les medias en tant qu'invité
     */
    public function testListAdminMediaAsGuestUser(): void
    {
        $userRepository = $this->service(UserRepository::class);
        /** @var User $guestUser */
        $guestUser = $userRepository->findOneBy(['admin' => false], ['id' => 'ASC']);
        
        self::assertNotNull($guestUser, 'Il faut au moins un utilisateur invité dans les fixtures.');

        $this->login($guestUser->getEmail());

        $this->get('/admin/media');
        $this->assertResponseIsSuccessful();

        $mediaRepository = $this->service(MediaRepository::class);
        $expectedMediaCount = $mediaRepository->count(['user' => $guestUser]);
        $expectedOnPage = min($expectedMediaCount, 25);

        $this->assertSelectorCount($expectedOnPage, '.admin-media-table tbody tr');
    }  

    /**
     * Vérification de l'ajout d'un media en tant qu'admin
     */
    public function testAddingMediaAsAdmin(): void
    {
        $this->login();

        $crawler = $this->get('/admin/media/add');
        $this->assertResponseIsSuccessful();


        $fakeImagePath = sys_get_temp_dir() . '/test_image.jpg';

        $image = imagecreate(10, 10);
        imagecolorallocate($image, 255, 255, 255);
        imagejpeg($image, $fakeImagePath);

        try {
            $uploadedFile = new UploadedFile(
                $fakeImagePath,
                'test_image.jpg',
                'image/jpeg',
                null,
                true
            );

            $form = $crawler->selectButton('Ajouter')->form(); 
            $adminUser = $this->service(UserRepository::class)->findOneBy(['admin' => true]);
            $album = $this->service(AlbumRepository::class)->findOneBy([]);

            $this->client->submit($form, [
                'media[file]' => $uploadedFile,
                'media[title]' => 'Ma superbe photo de test',
                'media[user]' => $adminUser->getId(),
                'media[album]' => $album->getId()
            ]);

            $this->assertResponseRedirects('/admin/media');

            $mediaRepository = $this->service(MediaRepository::class);
            $mediaInDb = $mediaRepository->findOneBy(['title' => 'Ma superbe photo de test', 'user' => $adminUser]);
            self::assertNotNull($mediaInDb);

        } finally {
   
            if (file_exists($fakeImagePath)) {
                unlink($fakeImagePath);
            }

            if (isset($mediaInDb) && $mediaInDb !== null) {
                $uploadedFilePath = self::getContainer()->getParameter('kernel.project_dir') . '/public/uploads/media/' . $mediaInDb->getFile();
                
                if (file_exists($uploadedFilePath)) {
                    unlink($uploadedFilePath);
                }
            }
        }
    }

    /**
     * Vérification de l'ajout d'un media en tant qu'invité
     */
    public function testAddingMediaAsGuestUser(): void
    {
        $userRepository = $this->service(UserRepository::class);
        /** @var User $guestUser */
        $guestUser = $userRepository->findOneBy(['admin' => false], ['id' => 'DESC']);
        
        self::assertNotNull($guestUser, 'Il faut un invité en BDD pour ce test.');

        $this->login($guestUser->getEmail());

        $crawler = $this->get('/admin/media/add');
        $this->assertResponseIsSuccessful();

        $fakeImagePath = sys_get_temp_dir() . '/guest_test_image.jpg';
        $image = imagecreate(10, 10);
        imagecolorallocate($image, 255, 255, 255);
        imagejpeg($image, $fakeImagePath);

        try {
            $uploadedFile = new UploadedFile(
                $fakeImagePath,
                'guest_test_image.jpg',
                'image/jpeg',
                null,
                true
            );

            $form = $crawler->selectButton('Ajouter')->form(); 

            $this->client->submit($form, [
                'media[file]' => $uploadedFile,
                'media[title]' => 'Photo déposée par un invité',
            ]);

            $this->assertResponseRedirects('/admin/media');

            $mediaRepository = $this->service(MediaRepository::class);
            $mediaInDb = $mediaRepository->findOneBy([
                'title' => 'Photo déposée par un invité', 
                'user' => $guestUser
            ]);
            
            self::assertNotNull($mediaInDb, "Le média aurait dû être enregistré et lié à l'invité connecté.");

        } finally {

            if (file_exists($fakeImagePath)) {
                unlink($fakeImagePath);
            }

            if (isset($mediaInDb) && $mediaInDb !== null) {
                $projectDir = self::getContainer()->getParameter('kernel.project_dir');
                $uploadedFilePath = $projectDir . '/public/uploads/media/' . $mediaInDb->getFile();
                
                if (file_exists($uploadedFilePath)) {
                    unlink($uploadedFilePath);
                }
            }
        }
    }

    /**
     * Vérification que l'ajout d'un media sans mettre d'image renvoie bien une erreur
     */
    public function testAddingMediaWithoutImageShouldFail(): void
    {
        $this->login('admin@test.com');

        $crawler = $this->get('/admin/media/add');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Ajouter')->form(); 

        $this->client->submit($form, [
            'media[file]' => null,
            'media[title]' => 'Titre sans image',
        ]);

        $this->assertResponseStatusCodeSame(200);

        $this->assertSelectorTextContains('.invalid-feedback', 'Le fichier doit être une image valide');
    }

    /**
     * Vérification qu'un invité peut supprimer un de ses médias
     */
    public function testUserCanDeleteTheirOwnMedia(): void
    {
        $userRepository = $this->service(UserRepository::class);
        $mediaRepository = $this->service(MediaRepository::class);

        /** @var User $guestUser */
        $guestUser = $userRepository->findOneBy(['admin' => false]);
        self::assertNotNull($guestUser, 'Il faut un invité pour ce test.');

        $mediaToDelete = $mediaRepository->findOneBy(['user' => $guestUser]);
        self::assertNotNull($mediaToDelete, 'Cet invité doit posséder au moins un média.');
        $mediaId = $mediaToDelete->getId();

        $this->login($guestUser->getEmail());
        $this->get(sprintf('/admin/media/delete/%d', $mediaId));
        $this->assertResponseRedirects('/admin/media');
        
        $this->getEntityManager()->clear();
        self::assertNull($mediaRepository->find($mediaId), 'Le média aurait dû être supprimé.');
    }

    /**
     * Vérification qu'un invité ne peut pas supprimer un média qui ne lui appartient pas
     */
    public function testUserCannotDeleteOtherUserMedia(): void
    {
        $userRepository = $this->service(UserRepository::class);
        $mediaRepository = $this->service(MediaRepository::class);

        $users = $userRepository->findBy(['admin' => false], ['id' => 'ASC'], 2);
        self::assertCount(2, $users, 'Il faut au moins deux invités dans les fixtures pour ce test.');
        
        [$guest1, $guest2] = $users;

        $mediaOfGuest2 = $mediaRepository->findOneBy(['user' => $guest2]);
        self::assertNotNull($mediaOfGuest2, 'Le deuxième invité doit avoir un média.');

        $this->login($guest1->getEmail());

        $this->get(sprintf('/admin/media/delete/%d', $mediaOfGuest2->getId()));
        $this->assertResponseStatusCodeSame(403);
        
        $this->getEntityManager()->clear();
        self::assertNotNull($mediaRepository->find($mediaOfGuest2->getId()), 'Le média ne doit pas être supprimé.');
    }

    /**
     * Vérification que si on essaye de supprimer un media qui n'existe pas renvoie une erreur
     */
    public function testDeleteWithInvalidIdReturns404(): void
    {
        $this->login();
        $this->client->request('POST', '/admin/media/delete/99999');
        $this->assertResponseStatusCodeSame(404);
    }

}