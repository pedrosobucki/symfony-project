<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Doctor {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  public int $id;

  /**
   * @ORM\Column(type="integer")
   */
  public int $crm;
  
  /**
   * @ORM\Column(type="string")
   */
  public string $name;

  public function getId() : int {
    return $this->id;
  }

  public function setId(int $id) : void {
    $this->id = $id;
  }

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