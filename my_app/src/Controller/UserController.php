<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/user/insert-session', name: 'user_insert_session')]
    public function InsertSession(Request $request): Response
    {
        $session = $request->getSession();

        if ($request->isMethod('POST')) {
            $session->set('username', $request->request->get('name'));

            return $this->redirectToRoute('user_get_session');
        }

        return $this->render('user/insert_session.html.twig', [
            'username' => $session->get('username', 'anonimo')
        ]);
    }

    #[Route('/user/get-session', name: 'user_get_session')]
    public function RetrieveSession(Request $request): Response
    {
        $session = $request->getSession();

        return $this->render('user/retrieve_session.html.twig', [
            'username' => $session->get('username', 'anonimo')
        ]);
    }

}