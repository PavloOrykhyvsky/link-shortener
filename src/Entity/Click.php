<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\ClickRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RedirectRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="clicks")
 */
class Click
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="bigint", name="link_id")
     */
    private int $linkId;

    /**
     * @ORM\Column(type="string")
     */
    private string $ip;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLinkId(): int
    {
        return $this->linkId;
    }

    public function setLinkId(int $linkId): self
    {
        $this->linkId = $linkId;

        return $this;
    }

    public function setLink(Link $link): self
    {
        $this->setLinkId($link->getId());

        return $this;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }
}
