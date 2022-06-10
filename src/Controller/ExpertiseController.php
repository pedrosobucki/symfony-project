<?php

namespace App\Controller;

use App\Entity\Expertise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpertiseController extends AbstractController{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /** 
     *@Route("/expertise", methods="POST")
     */
    public function create(Request $request) : Response {
        $content = json_decode($request->getContent());

        $expertise = new Expertise();
        $expertise->setDescription($content->description);

        $this->entityManager->persist($expertise);
        $this->entityManager->flush();

        return new JsonResponse($expertise);
    }
}
