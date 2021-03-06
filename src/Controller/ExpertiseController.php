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

        return new JsonResponse($expertise, Response::HTTP_CREATED);
    }

    /** 
     *@Route("/expertises", methods="GET")
     */
    public function getAll() : Response {
        $expertises = $this->repository->findAll();
        return new JsonResponse($expertises);
    }

    /** 
     *@Route("/expertises/{id}", methods="GET")
     */
    public function getById(int $id) : Response {
        $expertise = $this->repository->find($id);

        if(is_null($expertise))
            return new JsonResponse('', Response::HTTP_NO_CONTENT);

        return new JsonResponse($expertise);
    }

    /** 
     *@Route("/expertises/{id}", methods="PUT")
     */
    public function update(int $id, Request $request) : Response {
        $content = json_decode($request->getContent());

        $newExpertise = new Expertise();
        $newExpertise->setDescription($content->description);

        $fetchedExpertise = $this->repository->find($id);
        if(is_null($fetchedExpertise))
            return new JsonResponse('', Response::HTTP_NOT_FOUND);

        $fetchedExpertise->setDescription($newExpertise->getDescription());

        $this->entityManager->flush();

        return new JsonResponse($fetchedExpertise);
    }

    /** 
     *@Route("/expertises/{id}", methods="DELETE")
     */
    public function delete(int $id) : Response {

        $expertise = $this->repository->find($id);
        if(is_null($expertise))
            return new JsonResponse('', Response::HTTP_NOT_FOUND);

        $this->entityManager->remove($expertise);
        $this->entityManager->flush();

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }
}
