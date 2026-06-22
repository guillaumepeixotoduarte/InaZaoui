<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Entity\User;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MediaController extends AbstractController
{
    #[Route('/admin/media', name: 'admin_media_index')]
    public function index(Request $request, MediaRepository $mediaRepository): Response
    {
        $page = $request->query->getInt('page', 1);

        $criteria = [];

        if (!$this->isGranted('ROLE_ADMIN')) {
            $criteria['user'] = $this->getUser();
        }

        $medias = $mediaRepository->findBy(
            $criteria,
            ['id' => 'ASC'],
            25,
            25 * ($page - 1)
        );

        $total = $mediaRepository->count([]);

        return $this->render('admin/media/index.html.twig', [
            'medias' => $medias,
            'total' => $total,
            'page' => $page
        ]);
    }

    #[Route('/admin/media/add', name: 'admin_media_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $media = new Media();
        $form = $this->createForm(MediaType::class, $media, ['is_admin' => $this->isGranted('ROLE_ADMIN')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isGranted('ROLE_ADMIN')) {

                $user = $this->getUser();
                if ($user instanceof User) {
                    $media->setUser($user);
                }
            }

            $projectDir = $this->getParameter('kernel.project_dir');
            if (!is_string($projectDir)) {
                throw new \RuntimeException("Le paramètre kernel.project_dir est invalide.");
            }

            $publicDir = $projectDir . '/public';
            $uploadTargetDir = $publicDir . '/uploads/';

            $file = $media->getFile();
            if ($file instanceof UploadedFile) {
                $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
                $media->setPath('uploads/' . $newFilename);
                
                // On déplace le fichier physiquement
                $file->move($uploadTargetDir, $newFilename);
            } else {
                throw new \RuntimeException("Aucun fichier valide n'a été téléversé.");
            }
            $em->persist($media);
            $em->flush();

            return $this->redirectToRoute('admin_media_index');
        }

        return $this->render('admin/media/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/admin/media/delete/{id}', name: 'admin_media_delete')]
    public function delete(int $id, MediaRepository $mediaRepository, EntityManagerInterface $em): RedirectResponse
    {
        $media = $mediaRepository->find($id);

        if (!$media) {
            throw new NotFoundHttpException('Ce média n\'existe pas.');
        }

        if (!$this->isGranted('ROLE_ADMIN') && $media->getUser() !== $this->getUser()) {
            throw new AccessDeniedException('Vous n\'avez pas le droit de supprimer ce média.');
        }

        $filePath = $media->getPath();
        if ($filePath && file_exists($filePath)) {
            unlink($filePath);
        }

        $em->remove($media);
        $em->flush();

        return $this->redirectToRoute('admin_media_index');
    }
}