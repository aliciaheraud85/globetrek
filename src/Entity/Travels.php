<?php

namespace App\Entity;

use App\Repository\TravelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: TravelsRepository::class)]
class Travels
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;

    #[ORM\Column(type: 'text', nullable: false)]
    private ?string $description = null;

    #[ORM\Column(type: 'text',nullable: true)]
    private ?string $details = null;

    #[ORM\Column(length: 100)]
    private ?string $image1 = null;

    #[ORM\Column(length: 100)]
    private ?string $image2 = null;

    #[ORM\Column(length: 100)]
    private ?string $image3 = null;

    #[ORM\Column(length: 100)]
    private ?string $image4 = null;

    #[ORM\Column(length: 10)]
    private ?string $price1 = null;

    #[ORM\Column(length: 10)]
    private ?string $price2 = null;

    #[ORM\Column(length: 10)]
    private ?string $price3 = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $date1 = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $date2 = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTime $date3 = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[Gedmo\Slug(fields: ['title'])]
    #[ORM\Column(length: 255, nullable: true, unique:true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'travels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categories = null;

    #[ORM\ManyToOne(inversedBy: 'travels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'travels')]
    private Collection $comments;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'travels')]
    private Collection $reservations;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(string $image1): static
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(string $image2): static
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(string $image3): static
    {
        $this->image3 = $image3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image4;
    }

    public function setImage4(string $image4): static
    {
        $this->image4 = $image4;

        return $this;
    }

    public function getPrice1(): ?string
    {
        return $this->price1;
    }

    public function setPrice1(string $price1): static
    {
        $this->price1 = $price1;

        return $this;
    }

    public function getPrice2(): ?string
    {
        return $this->price2;
    }

    public function setPrice2(string $price2): static
    {
        $this->price2 = $price2;

        return $this;
    }

    public function getPrice3(): ?string
    {
        return $this->price3;
    }

    public function setPrice3(string $price3): static
    {
        $this->price3 = $price3;

        return $this;
    }

    public function getDate1(): ?\DateTime
    {
        return $this->date1;
    }

    public function setDate1(\DateTime $date1): static
    {
        $this->date1 = $date1;

        return $this;
    }

    public function getDate2(): ?\DateTime
    {
        return $this->date2;
    }

    public function setDate2(\DateTime $date2): static
    {
        $this->date2 = $date2;

        return $this;
    }

    public function getDate3(): ?\DateTime
    {
        return $this->date3;
    }

    public function setDate3(\DateTime $date3): static
    {
        $this->date3 = $date3;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTravels($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTravels() === $this) {
                $comment->setTravels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setTravels($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getTravels() === $this) {
                $reservation->setTravels(null);
            }
        }

        return $this;
    }
}
