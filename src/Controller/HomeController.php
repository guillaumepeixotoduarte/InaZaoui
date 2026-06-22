<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

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

        if ($guest === null) {
            throw $this->createNotFoundException("Cet invité n'existe pas.");
        }

        return $this->render('front/guest.html.twig', [
            'guest' => $guest
        ]);
    }

    #[Route('/portfolio/{id}', name: 'portfolio')]
    public function portfolio(AlbumRepository $albumRepository, UserRepository $userRepository, MediaRepository $mediaRepository, ?int $id = null): Response
    {
        $albums = $albumRepository->findAll();
        $album = ($id !== null) ? $albumRepository->find($id) : null;
        $user = $userRepository->findOneBy(['admin' => true]);

        if ($album instanceof Album) {
            $medias = $mediaRepository->findBy(['album' => $album]);
        } else {
            $medias = $user instanceof User ? $mediaRepository->findBy(['user' => $user]) : [];
        }


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