<?php

namespace App\Entity;

class Doctor {

  public int $crm;
  public string $name;

  public function getCrm() : int {
    return $this->crm;
  }

  public function setCrm(int $crm) : void {
    $this->crm = $crm;
  }

  public function getName() : string {
    return $this->name;
  }

  public function setName(string $name) : void {
    $this->name = $name;
  }

}

?>