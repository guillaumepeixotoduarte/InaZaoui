<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlbumFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for( $i = 1; $i <= 5; $i++) {
            $album = new Album();
            $album->setName('Album ' . $i);

            $manager->persist($album);

            $this->addReference('album_' . $i, $album);
        }

        $manager->flush();
    }

    /**
     * 💡 Indiquation pour PHPStan
     * @return array<int, class-string>
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}