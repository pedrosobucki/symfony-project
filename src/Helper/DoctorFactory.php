<?php

namespace App\Helper;

use App\Entity\Doctor;

class DoctorFactory{

  public function createDoctor(string $json) : Doctor {

    $content = json_decode($json);

    //initiates doctor object
    $doctor = new Doctor();

    //sets fields
    $doctor->setCrm($content->crm);
    $doctor->setName($content->name);

    //return doctor entity
    return $doctor;
  }
}

?>