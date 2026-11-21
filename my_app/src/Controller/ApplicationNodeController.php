<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ApplicationNode;

class ApplicationNodeController extends AbstractController
{
    #[Route('/application-node/index', name: 'application_node_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(ApplicationNode::class);
        $applicationNodes = $repository->findAll();

        return $this->render('application_node/index.html.twig', [
            'applicationNodes' => $applicationNodes
        ]);
    }

    #[Route('/application-node/create', name: 'application_node_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $ip = $request->request->get('ip');

            $applicationNode = new ApplicationNode();
            $applicationNode->setName($name);
            $applicationNode->setIp($ip);

            $entityManager->persist($applicationNode);
            $entityManager->flush();

            return $this->redirectToRoute('application_node_index');
        }

        return $this->render('application_node/create.html.twig');
    }
}