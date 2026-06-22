<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends AbstractController
{

    #[Route('/admin/invite', name: 'admin_user_index')]
    #[isGranted('ROLE_ADMIN')]
    public function index(Request $request, UserRepository $userRepository): Response
    {

        $page = $request->query->getInt('page', 1);

        $users = $userRepository->findBy(
            [],
            ['id' => 'ASC'],
            25,
            25 * ($page - 1)
        );

        $total = $userRepository->count([]);

        return $this->render('admin/user/index.html.twig', ['users' => $users, 'total' => $total, 'page' => $page]);
    }

    #[Route('/admin/invite/add', name: 'admin_user_add')]
    #[isGranted('ROLE_ADMIN')]
    public function add(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('password')->getData();

            if (!is_string($plainPassword) || $plainPassword === '') {
                throw new \RuntimeException("Le mot de passe fourni n'est pas valide.");
            }

            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/admin/invite/delete/{id}', name: 'admin_user_delete')]
    #[isGranted('ROLE_ADMIN')]
    public function delete(int $id, UserRepository $userRepository, EntityManagerInterface $em): RedirectResponse
    {
        $user = $userRepository->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException("Cet utilisateur n'existe pas.");
        }

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin_user_index');
    }

    #[Route('/admin/invite/switch_access/{id}', name: 'admin_user_switch_access')]
    #[isGranted('ROLE_ADMIN')]
    public function switchAccess(int $id, UserRepository $userRepository, EntityManagerInterface $em): RedirectResponse
    {
        $user = $userRepository->find($id);
        
        if (!$user instanceof User) {
            throw new NotFoundHttpException("Cet utilisateur n'existe pas.");
        }

        $user->setActive(!$user->isActive());
        $em->flush();

        return $this->redirectToRoute('admin_user_index');
    }

}