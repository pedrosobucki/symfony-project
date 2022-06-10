<?php

namespace App\Helper;

use App\Entity\Doctor;
use App\Repository\ExpertiseRepository;

class DoctorFactory{

  private ExpertiseRepository $expertiseRepository;

  public function __construct(ExpertiseRepository $expertiseRepository) {
    $this->expertiseRepository = $expertiseRepository;
  }

  public function createDoctor(string $json) : Doctor {

    $content = json_decode($json);

    //initiates doctor object
    $doctor = new Doctor();

    //sets fields
    $doctor->setCrm($content->crm);
    $doctor->setName($content->name);

    $expertise = $this->expertiseRepository->find($content->expertiseId);
    $doctor->setExpertise($expertise);

    //return doctor entity
    return $doctor;
  }
}

?>