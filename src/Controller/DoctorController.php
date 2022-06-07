<?php

namespace App\Controller;

use App\Entity\Doctor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DcotorController {

  /**
   * @Route("/doctors", methods="POST")
   */
  public function create(Request $request) : Response {
    $content = json_decode($request->getContent());
    $doctor = new Doctor();

    $doctor->setCrm($content->crm);
    $doctor->setName($content->name);

    return new JsonResponse($doctor);
  }
}
?>