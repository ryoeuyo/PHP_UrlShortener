<?php

namespace App\Infrastructure\Persistence\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'shorten_url_clicks')]
class ShortenUrlClick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ShortenUrl::class)]
    #[ORM\JoinColumn(name: 'shorten_url_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ShortenUrl $shortenUrl;

    #[ORM\Column(name: 'clicked_at', type: 'datetime_immutable')]
    private DateTimeImmutable $clickedAt;

    #[ORM\Column(name: 'ip_address', type: 'string', length: 255)]
    private string $ipAddress;

    #[ORM\Column(name: 'user_agent', type: 'string', length: 255)]
    private string $userAgent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClickedAt(): DateTimeImmutable
    {
        return $this->clickedAt;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setClickedAt(DateTimeImmutable $clickedAt): self
    {
        $this->clickedAt = $clickedAt;

        return $this;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getShortenUrl(): ShortenUrl
    {
        return $this->shortenUrl;
    }

    public function setShortenUrl(ShortenUrl $shortenUrl): self
    {
        $this->shortenUrl = $shortenUrl;

        return $this;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
