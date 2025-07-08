<?php

namespace App\Entity\AdoptionRequest;

use App\Entity\User;
use App\Repository\AdoptionRequest\CommentRepository;
use App\Traits\Entity as EntityTraits;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use EntityTraits\IdTrait;
    use TimestampableEntity;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private AdoptionRequest $adoptionRequest;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getAdoptionRequest(): AdoptionRequest
    {
        return $this->adoptionRequest;
    }

    public function setAdoptionRequest(AdoptionRequest $adoptionRequest): self
    {
        $this->adoptionRequest = $adoptionRequest;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}