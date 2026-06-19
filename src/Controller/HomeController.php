<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function __construct(private \Doctrine\Persistence\ManagerRegistry $managerRegistry)
    {
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('front/home.html.twig');
    }

    #[Route('/guests', name: 'guests')]
    public function guests(UserRepository $userRepository): Response
    {
        $guests = $userRepository->findAllGuestsWithMedias();
        return $this->render('front/guests.html.twig', [
            'guests' => $guests
        ]);
    }

    #[Route('/guest/{id}', name: 'guest')]
    public function guest(int $id, UserRepository $userRepository): Response
    {
        $guest = $userRepository->findOneWithMedias($id);

        if (!$guest) {
            throw $this->createNotFoundException("Cet invité n'existe pas.");
        }

        return $this->render('front/guest.html.twig', [
            'guest' => $guest
        ]);
    }

    #[Route('/portfolio/{id}', name: 'portfolio')]
    public function portfolio(?int $id = null): Response
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
    public function about(): Response
    {
        return $this->render('front/about.html.twig');
    }
}