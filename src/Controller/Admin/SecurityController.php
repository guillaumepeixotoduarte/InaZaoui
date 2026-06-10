<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(private \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils)
    {
    }
    /**
     * @Route("/login", name="admin_login")
     */
    public function login(): \Symfony\Component\HttpFoundation\Response
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();
        return $this->render('admin/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}