<?php

namespace App\Controller;

use App\Entity\Expertise;
use App\Repository\ExpertiseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpertiseController extends AbstractController{

    private EntityManagerInterface $entityManager;
    private ExpertiseRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ExpertiseRepository $repository
    ){
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }
    /** 
     *@Route("/expertises", methods="POST")
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
