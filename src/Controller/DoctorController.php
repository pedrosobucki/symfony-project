<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Helper\DoctorFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DoctorController extends AbstractController{

  private EntityManagerInterface $entityManager;
  private ManagerRegistry $doctrine;
  private DoctorFactory $doctorFactory;

  public function __construct(
    EntityManagerInterface $entityManager,
    ManagerRegistry $doctrine,
    DoctorFactory $doctorFactory
  ) {
    $this->entityManager = $entityManager;
    $this->doctrine = $doctrine;
    $this->doctorFactory = $doctorFactory;
  }

  private function getDoctrine() : ManagerRegistry {
    return $this->doctrine;
  }

  private function doctorFactory() : DoctorFactory {
    return $this->doctorFactory;
  }

  /**
   * @Route("/doctors", methods="POST")
   */
  public function create(Request $request) : Response {
    $doctor = $this->doctorFactory()->createDoctor($request->getContent());

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

    $doctor = $this->searchDoctorById($id);

    $httpCode = 200;
    if(is_null($doctor))
      $httpCode = Response::HTTP_NO_CONTENT;

    return new JsonResponse($doctor, $httpCode);
  }

  /**
   * @Route("/doctors/{id}", methods="PUT")
   */
  public function update(int $id, Request $request) : Response {

    $content = json_decode($request->getContent());
    $newDoctor = $this->doctorFactory()->createDoctor($request->getContent());

    $fetchedDoctor = $this->searchDoctorById($id);

    if(is_null($fetchedDoctor))
      return new JsonResponse('', Response::HTTP_NOT_FOUND);

    $fetchedDoctor->setCrm($newDoctor->getCrm());
    $fetchedDoctor->setName($newDoctor->getName());
    $fetchedDoctor->setExpertise($newDoctor->getExpertise());

    $this->entityManager->flush();

    return new JsonResponse($fetchedDoctor);
  }

  /**
   * @Route("/doctors/{id}", methods="DELETE")
   */
  public function delete(int $id, Request $request) : Response {

    $doctor = $this->searchDoctorById($id);

    if(is_null($doctor))
      return new JsonResponse('', Response::HTTP_NOT_FOUND);

    $this->entityManager->remove($doctor);
    $this->entityManager->flush();

    return new JsonResponse('', Response::HTTP_NO_CONTENT);
  }

  private function searchDoctorById(int $id){
    $doctorRespository = $this->getDoctrine()->getRepository(Doctor::class);
    return $doctorRespository->find($id);
  }
}
?>