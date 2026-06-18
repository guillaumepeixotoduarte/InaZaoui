<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\User;
use App\Entity\Album;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\AlbumFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $userAdmin = $this->getReference('user_admin', User::class);

        $increment = 1;
        for($i = 1; $i <= 5; $i++) {
            $album = $this->getReference('album_' . $i, Album::class);
            for($j = 1; $j <= 3; $j++) {
                $media = new Media();
                $media->setTitle('Média ' . $j . ' de l\'album ' . $album->getName());
                $filename = sprintf('%04d.jpg', $increment);
                $media->setPath('uploads/' . $filename);
                $media->setAlbum($album);
                $media->setUser($userAdmin);
                $manager->persist($media);
                $increment++;
            }
        }
        
        for($i = 1; $i <= 10; $i++) {
            $user = $this->getReference('user_' . $i, User::class);
            for ($j = 1; $j <= 3; $j++) {
                $media = new Media();
                $media->setTitle('Média ' . $j . ' de ' . $user->getName());
                $filename = sprintf('%04d.jpg', $increment);
                $media->setPath('uploads/' . $filename);
                $media->setUser($user);
                $manager->persist($media);
                $increment++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }
}