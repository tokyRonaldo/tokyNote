<?php

namespace App\Entity;

use App\Repository\BlocNoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlocNoteRepository::class)
 */
class BlocNote
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
     * @ORM\Column(type="text",length=255)
     */
    private $todo;

    /**
     * 
     * 
     * @ORM\Column(type="text")
     */
    private $doing;

    
    /**
     * 
     * 
     * @ORM\Column(type="text")
     */
    private $did;
   
    function getId()
    {
        return $this->id;
    }
   
    function getToDo()
    {
        return $this->todo;
    }
    function getDoing()
    {
        return $this->doing;
    }
    function getDid()
    {
        return $this->did;
    }

    

    function setTodo($todo)
    {
         $this->todo=$todo;
    }
    function setDoing($doing)
    {
         $this->doing=$doing;
    }
    function setDid($did)
    {
         $this->did=$did;
    }
}
