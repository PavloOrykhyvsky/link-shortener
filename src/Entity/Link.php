<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="links")
 */
class Link
{
    use Timestampable;

    public const DEFAULT_IS_ACTIVE = true;
    public const DEFAULT_IS_FAVOURITE = false;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer", name="user_id")
     */
    private int $userId;

    /**
     * @ORM\Column(type="string")
     */
    private string $title;

    /**
     * @ORM\Column(type="string")
     */
    private string $redirectUrl;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $urlPath;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="User",
     *      inversedBy="link"
     * )
     * @ORM\JoinColumn(
     *      name="user_id",
     *      referencedColumnName="id",
     *      onDelete="CASCADE",
     *      nullable=false
     * )
     */
    private $user;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Click",
     *      mappedBy="link",
     *      cascade={"persist", "remove"}
     * )
     */
    private $clicks;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private bool $isActive = self::DEFAULT_IS_ACTIVE;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $isFavourite = self::DEFAULT_IS_FAVOURITE;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setOwner($user): self
    {
        $this->setUserId($user->getId());

        return $this;
    }

    public function isOwner(User $user): bool
    {
        return $this->getUserId() === $user->getId();
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    public function setRedirectUrl(string $redirectUrl): self
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getUrlPath(): string
    {
        return $this->urlPath;
    }

    public function setUrlPath(string $urlPath): self
    {
        $this->urlPath = $urlPath;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->getIsActive();
    }

    public function isNotActive(): bool
    {
        return !$this->isActive();
    }

    public function getIsFavourite(): bool
    {
        return $this->isFavourite;
    }

    public function setIsFavourite(bool $isFavourite): self
    {
        $this->isFavourite = $isFavourite;

        return $this;
    }
}
