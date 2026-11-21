<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\ApplicationNode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends AbstractController
{
    #[Route('/person/index', name: 'person_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Person::class);
        $people = $repository->findAll();

        return $this->render('person/index.html.twig', [
            'people' => $people
        ]);
    }

    #[Route('/person/create', name: 'person_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $application_node_repository = $entityManager->getRepository(ApplicationNode::class);
        $result = $application_node_repository->findOneBy([
            'ip' => $_SERVER['SERVER_ADDR']
        ]);

        if (!$result) {
            return new Response('nenhum nó com o ip: ' . $_SERVER['SERVER_ADDR']);
        }


        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');

            $person = new Person();
            $person->setName($name);

            $entityManager->persist($person);
            $entityManager->flush();

            return $this->redirectToRoute('person_index');
        }

        return $this->render('person/create.html.twig');
    }
}