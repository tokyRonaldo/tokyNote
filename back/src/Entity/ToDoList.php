<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ToDoListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToDoListRepository::class)
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * 
     * 
     * @ORM\Column(type="string",length=255)
     */
    private $title;

    /**
     * 
     * 
     * @ORM\Column(type="text")
     */
    private $description;


   
    function getTitle()
    {
        return $this->title;
    }
    function getDescription()
    {
        return $this->description;
    }
   
    function setTitle($title)
    {
         $this->title=$title;
    }
    function setDescription($description)
    {
         $this->description=$description;
    }
}
