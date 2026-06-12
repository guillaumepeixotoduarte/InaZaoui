<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(private \Doctrine\Persistence\ManagerRegistry $managerRegistry)
    {
    }

    #[Route('/', name: 'home')]
    public function home(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('front/home.html.twig');
    }

    #[Route('/guests', name: 'guests')]
    public function guests(): \Symfony\Component\HttpFoundation\Response
    {
        $guests = $this->managerRegistry->getRepository(User::class)->findBy(['admin' => false]);
        return $this->render('front/guests.html.twig', [
            'guests' => $guests
        ]);
    }

    #[Route('/guest/{id}', name: 'guest')]
    public function guest(int $id): \Symfony\Component\HttpFoundation\Response
    {
        $guest = $this->managerRegistry->getRepository(User::class)->find($id);
        return $this->render('front/guest.html.twig', [
            'guest' => $guest
        ]);
    }

    #[Route('/portfolio/{id}', name: 'portfolio')]
    public function portfolio(?int $id = null): \Symfony\Component\HttpFoundation\Response
    {
        $albums = $this->managerRegistry->getRepository(Album::class)->findAll();
        $album = $id ? $this->managerRegistry->getRepository(Album::class)->find($id) : null;
        $user = $this->managerRegistry->getRepository(User::class)->findOneBy(['admin' => true]);

        $medias = $album
            ? $this->managerRegistry->getRepository(Media::class)->findBy(['album' => $album])
            : $this->managerRegistry->getRepository(Media::class)->findBy(['user' => $user]);
        return $this->render('front/portfolio.html.twig', [
            'albums' => $albums,
            'album' => $album,
            'medias' => $medias
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('front/about.html.twig');
    }
}