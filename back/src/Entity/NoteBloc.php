<?php

namespace App\Entity;

use App\Repository\NoteBlocRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=NoteBlocRepository::class)
 * @ApiResource(
 * attributes={"order"={"updated_at":"DESC"}},
 * paginationItemsPerPage=10,
 * normalizationContext={"groups"={"read:noteBloc"}},
 * collectionOperations={

 *          "post",
 *          "get"
 * },
 * itemOperations={
 *          "get",
 *          "put"={
 *              "denormalization_context"={"groups"={"edit:noteBloc"}}  
 *          },
 *          "delete"
 *              
 * },
 * )
 * @ApiFilter(SearchFilter::class,properties={"type":"exact"})
 */
class NoteBloc
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"read:noteBloc"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:noteBloc","edit:noteBloc"})
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:noteBloc","edit:noteBloc"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="noteBlocs")
     * @Groups({"read:noteBloc","edit:noteBloc"})
     */
    private $userId;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"read:noteBloc"})
     */
    private $created_at;

    /**
     *  @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"read:noteBloc","edit:noteBloc"})
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $test_date;

    public function __construct(){
        // $this->created_at=new DateTimeImmutable(); ;
        // $this->updated_at=new DateTimeImmutable(); ;
        $this->type= 'to_do' ;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatdAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTestDate(): ?\DateTimeInterface
    {
        return $this->test_date;
    }

    public function setTestDate(?\DateTimeInterface $test_date): self
    {
        $this->test_date = $test_date;

        return $this;
    }
}

//note
//filter les donnes
//  @ApiFilter(SearchFilter::class,properties={"type":"exact"})

//recuperer des attributs suppementaire sur un iteme particulier
// itemOperations={"get"={"normalization_context"={"groups"={"read:comment","read:full:comment"}}}},

//question authentification lors de create et utilisation d'un controller avant post
// collectionOperations={
//     *          "get",
//     *          "post"={
//     *              "security"="is_granted('IS_AUTHENTICATED_FULLY')",
//     *              "controller"=App\Controller\ApiCreateController::class
//     *            }
//     * },