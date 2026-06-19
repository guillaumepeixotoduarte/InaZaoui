<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Form\MediaType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MediaController extends AbstractController
{
    public function __construct(private ManagerRegistry $managerRegistry)
    {
    }
    /**
     * @Route("/admin/media", name="admin_media_index")
     */
    #[Route('/admin/media', name: 'admin_media_index')]
    public function index(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $page = $request->query->getInt('page', 1);

        $criteria = [];

        if (!$this->isGranted('ROLE_ADMIN')) {
            $criteria['user'] = $this->getUser();
        }

        $medias = $this->managerRegistry->getRepository(Media::class)->findBy(
            $criteria,
            ['id' => 'ASC'],
            25,
            25 * ($page - 1)
        );

        /** @var EntityRepository $repository */
        $repository = $this->managerRegistry->getRepository(Media::class);

        $total = $repository->count([]);

        return $this->render('admin/media/index.html.twig', [
            'medias' => $medias,
            'total' => $total,
            'page' => $page
        ]);
    }

    #[Route('/admin/media/add', name: 'admin_media_add')]
    public function add(Request $request)
    {
        $media = new Media();
        $form = $this->createForm(MediaType::class, $media, ['is_admin' => $this->isGranted('ROLE_ADMIN')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                $media->setUser($this->getUser());
            }

            $publicDir = $this->getParameter('kernel.project_dir') . '/public';
            $uploadTargetDir = $publicDir . '/uploads/';

            $media->setPath('uploads/' . md5(uniqid()) . '.' . $media->getFile()->guessExtension());
            $media->getFile()->move($uploadTargetDir, $media->getPath());
            $this->managerRegistry->getManager()->persist($media);
            $this->managerRegistry->getManager()->flush();

            return $this->redirectToRoute('admin_media_index');
        }

        return $this->render('admin/media/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/admin/media/delete/{id}', name: 'admin_media_delete')]
    public function delete(int $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $media = $this->managerRegistry->getRepository(Media::class)->find($id);

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

        $this->managerRegistry->getManager()->remove($media);
        $this->managerRegistry->getManager()->flush();

        return $this->redirectToRoute('admin_media_index');
    }
}