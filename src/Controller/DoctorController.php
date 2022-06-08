<?php

namespace App\Controller;

use App\Entity\Doctor;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DoctorController extends AbstractController{

  private $entityManager;
  private $doctrine;

  public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $doctrine) {
    $this->entityManager = $entityManager;
    $this->doctrine = $doctrine;
  }

  private function getDoctrine() : ManagerRegistry {
    return $this->doctrine;
  }

  /**
   * @Route("/doctors", methods="POST")
   */
  public function create(Request $request) : Response {
    $content = json_decode($request->getContent());
    $doctor = new Doctor();

    $doctor->setCrm($content->crm);
    $doctor->setName($content->name);

    $this->entityManager->persist($doctor);
    $this->entityManager->flush();

    return new JsonResponse($doctor);
  }

  /**
   * @Route("/doctors", methods="GET")
   */
  public function getAll() : Response {

    $doctorRespository = $this->getDoctrine()->getRepository(Doctor::class);

    $doctors = $doctorRespository->findAll();

    return new JsonResponse($doctors);
  }

  /**
   * @Route("/doctors/{id}", methods="GET")
   */
  public function getById(int $id) : Response {

    $doctorRespository = $this->getDoctrine()->getRepository(Doctor::class);
    $doctors = $doctorRespository->find($id);

    $httpCode = 200;
    if(is_null($doctors))
      $httpCode = Response::HTTP_NO_CONTENT;

    return new JsonResponse($doctors, $httpCode);
  }

  /**
   * @Route("/doctors/{id}", methods="PUT")
   */
  public function update(int $id, Request $request) : Response {

    $content = json_decode($request->getContent());
    $newDoctor = new Doctor();

    $newDoctor->setCrm($content->crm);
    $newDoctor->setName($content->name);

    $doctorRespository = $this->getDoctrine()->getRepository(Doctor::class);
    $fetchedDoctor = $doctorRespository->find($id);

    if(is_null($fetchedDoctor))
      return new JsonResponse('', Response::HTTP_NOT_FOUND);

    $fetchedDoctor->setCrm($newDoctor->getCrm());
    $fetchedDoctor->setName($newDoctor->getName());

    $this->entityManager->flush();

    return new JsonResponse($fetchedDoctor);
  }
}
?>