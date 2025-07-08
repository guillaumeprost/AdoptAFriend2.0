<?php

namespace App\Entity\AdoptionRequest;

use App\Entity\Animal\Animal;
use App\Entity\User;
use App\Repository\AdoptionRequest\AdoptionRequestRepository;
use App\Traits\Entity as EntityTraits;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AdoptionRequestRepository::class)]
class AdoptionRequest
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_ADOPTED = 'adopted';

    use EntityTraits\IdTrait;
    use EntityTraits\DescriptionTrait;
    use TimestampableEntity;

    #[ORM\Column(nullable: false)]
    private string $status = self::STATUS_NEW;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $adopter;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'adoptionRequests')]
    #[ORM\JoinColumn(name: 'animal_id', referencedColumnName: 'id')]
    private Animal $animal;


    #[ORM\OneToMany(mappedBy: 'adoptionRequest', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getAdopter(): User
    {
        return $this->adopter;
    }

    public function setAdopter(User $adopter): void
    {
        $this->adopter = $adopter;
    }

    public function getAnimal(): Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): self
    {
        $this->animal = $animal;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAdoptionRequest($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getAdoptionRequest() === $this) {
                $comment->setAdoptionRequest(null);
            }
        }

        return $this;
    }
}
