<?php

namespace App\Entity;

use App\Repository\WatchHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchHistoryRepository::class)]
class WatchHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastWatched = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfViews = null;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'watchHistory')]
    private Collection $mediaWatch;

    #[ORM\ManyToOne(inversedBy: 'watchHistories')]
    private ?User $userWatch = null;

    public function __construct()
    {
        $this->mediaWatch = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastWatched(): ?\DateTimeInterface
    {
        return $this->lastWatched;
    }

    public function setLastWatched(?\DateTimeInterface $lastWatched): static
    {
        $this->lastWatched = $lastWatched;

        return $this;
    }

    public function getNumberOfViews(): ?int
    {
        return $this->numberOfViews;
    }

    public function setNumberOfViews(?int $numberOfViews): static
    {
        $this->numberOfViews = $numberOfViews;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMediaWatch(): Collection
    {
        return $this->mediaWatch;
    }

    public function addMediaWatch(Media $mediaWatch): static
    {
        if (!$this->mediaWatch->contains($mediaWatch)) {
            $this->mediaWatch->add($mediaWatch);
            $mediaWatch->setWatchHistory($this);
        }

        return $this;
    }

    public function removeMediaWatch(Media $mediaWatch): static
    {
        if ($this->mediaWatch->removeElement($mediaWatch)) {
            // set the owning side to null (unless already changed)
            if ($mediaWatch->getWatchHistory() === $this) {
                $mediaWatch->setWatchHistory(null);
            }
        }

        return $this;
    }

    public function getUserWatch(): ?User
    {
        return $this->userWatch;
    }

    public function setUserWatch(?User $userWatch): static
    {
        $this->userWatch = $userWatch;

        return $this;
    }
}
