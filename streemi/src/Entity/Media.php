<?php

namespace App\Entity;

use App\Enum\MediaTypeEnum;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['serie' => Serie::class, 'movie' => Movie::class])]
#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $shortDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $longDescription = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $releaseDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverImage = null;

    #[ORM\Column]
    private array $staff = [];

    #[ORM\Column]
    private array $caster = [];

    #[ORM\ManyToOne(inversedBy: 'mediaWatch')]
    private ?WatchHistory $watchHistory = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: MediaTypeEnum::class)]
    private array $mediaType = [];

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'media')]
    private Collection $mediaCategory;

    /**
     * @var Collection<int, Language>
     */
    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'media')]
    private Collection $mediaLanguage;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\ManyToMany(targetEntity: Playlist::class, inversedBy: 'media')]
    private Collection $mediaPlaylist;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'media')]
    private Collection $comment;

    /**
     * @var Collection<int, PlaylistMedia>
     */
    #[ORM\OneToMany(targetEntity: PlaylistMedia::class, mappedBy: 'media')]
    private Collection $playlistMedia;

    public function __construct()
    {
        $this->mediaCategory = new ArrayCollection();
        $this->mediaLanguage = new ArrayCollection();
        $this->mediaPlaylist = new ArrayCollection();
        $this->comment = new ArrayCollection();
        $this->playlistMedia = new ArrayCollection();
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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(string $longDescription): static
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeImmutable $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): static
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getStaff(): array
    {
        return $this->staff;
    }

    public function setStaff(array $staff): static
    {
        $this->staff = $staff;

        return $this;
    }

    public function getCaster(): array
    {
        return $this->caster;
    }

    public function setCaster(array $caster): static
    {
        $this->caster = $caster;

        return $this;
    }

    public function getWatchHistory(): ?WatchHistory
    {
        return $this->watchHistory;
    }

    public function setWatchHistory(?WatchHistory $watchHistory): static
    {
        $this->watchHistory = $watchHistory;

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getMediaLanguages(): Collection
    {
        return $this->mediaLanguages;
    }

    public function addMediaLanguage(Language $mediaLanguage): static
    {
        if (!$this->mediaLanguages->contains($mediaLanguage)) {
            $this->mediaLanguages->add($mediaLanguage);
            $mediaLanguage->setMedia($this);
        }

        return $this;
    }

    public function removeMediaLanguage(Language $mediaLanguage): static
    {
        if ($this->mediaLanguages->removeElement($mediaLanguage)) {
            // set the owning side to null (unless already changed)
            if ($mediaLanguage->getMedia() === $this) {
                $mediaLanguage->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistMedia>
     */
    public function getPlaylistMedia(): Collection
    {
        return $this->playlistMedia;
    }

    public function addPlaylistMedium(PlaylistMedia $playlistMedium): static
    {
        if (!$this->playlistMedia->contains($playlistMedium)) {
            $this->playlistMedia->add($playlistMedium);
            $playlistMedium->addMediaPlaylist($this);
        }

        return $this;
    }

    public function removePlaylistMedium(PlaylistMedia $playlistMedium): static
    {
        if ($this->playlistMedia->removeElement($playlistMedium)) {
            $playlistMedium->removeMediaPlaylist($this);
        }

        return $this;
    }

    /**
     * @return MediaTypeEnum[]
     */
    public function getMediaType(): array
    {
        return $this->mediaType;
    }

    public function setMediaType(array $mediaType): static
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getMediaCategory(): Collection
    {
        return $this->mediaCategory;
    }

    public function addMediaCategory(Category $mediaCategory): static
    {
        if (!$this->mediaCategory->contains($mediaCategory)) {
            $this->mediaCategory->add($mediaCategory);
        }

        return $this;
    }

    public function removeMediaCategory(Category $mediaCategory): static
    {
        $this->mediaCategory->removeElement($mediaCategory);

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getMediaLanguage(): Collection
    {
        return $this->mediaLanguage;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getMediaPlaylist(): Collection
    {
        return $this->mediaPlaylist;
    }

    public function addMediaPlaylist(Playlist $mediaPlaylist): static
    {
        if (!$this->mediaPlaylist->contains($mediaPlaylist)) {
            $this->mediaPlaylist->add($mediaPlaylist);
        }

        return $this;
    }

    public function removeMediaPlaylist(Playlist $mediaPlaylist): static
    {
        $this->mediaPlaylist->removeElement($mediaPlaylist);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment);
            $comment->setMedia($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMedia() === $this) {
                $comment->setMedia(null);
            }
        }

        return $this;
    }
}
