<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends AbstractController
{
    public function __construct(private ManagerRegistry $managerRegistry)
    {
    }


    #[Route('/admin/invite', name: 'admin_user_index')]
    #[isGranted('ROLE_ADMIN')]
    public function index(Request $request): \Symfony\Component\HttpFoundation\Response
    {

        $page = $request->query->getInt('page', 1);

        $users = $this->managerRegistry->getRepository(User::class)->findBy(
            [],
            ['id' => 'ASC'],
            25,
            25 * ($page - 1)
        );

        /** @var EntityRepository $repository */
        $repository = $this->managerRegistry->getRepository(User::class);

        $total = $repository->count([]);

        return $this->render('admin/user/index.html.twig', ['users' => $users, 'total' => $total, 'page' => $page]);
    }

    #[Route('/admin/user/add', name: 'admin_user_add')]
    #[isGranted('ROLE_ADMIN')]
    public function add(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $this->managerRegistry->getManager()->persist($user);
            $this->managerRegistry->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/admin/user/delete/{id}', name: 'admin_user_delete')]
    #[isGranted('ROLE_ADMIN')]
    public function delete(int $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $user = $this->managerRegistry->getRepository(User::class)->find($id);
        $this->managerRegistry->getManager()->remove($user);
        $this->managerRegistry->getManager()->flush();

        return $this->redirectToRoute('admin_user_index');
    }

    #[Route('/admin/user/switch_access/{id}', name: 'admin_user_switch_access')]
    #[isGranted('ROLE_ADMIN')]
    public function switchAccess(int $id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $user = $this->managerRegistry->getRepository(User::class)->find($id);
        $user->setActive(!$user->isActive());
        $this->managerRegistry->getManager()->flush();

        return $this->redirectToRoute('admin_user_index');
    }

}