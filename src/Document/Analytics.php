<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: 'analytics')]
class Analytics
{
    #[ODM\Id]
    protected ?string $id;
    #[ODM\Field]
    protected string $userIpAddress;
    #[ODM\Field]
    protected string $accessDate;
    #[ODM\Field]
    protected string $accessTime;
    #[ODM\Field]
    protected string $status;
    #[ODM\Field]
    protected string $url;
    #[ODM\Field]
    protected string $userAgent;


    //Getters and setters
    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getUserIpAddress(): string
    {
        return $this->userIpAddress;
    }

    public function setUserIpAddress(string $userIpAddress): void
    {
        $this->userIpAddress = $userIpAddress;
    }

    public function getAccessDate(): string
    {
        return $this->accessDate;
    }

    public function setAccessDate(string $accessDate): void
    {
        $this->accessDate = $accessDate;
    }

    public function getAccessTime(): string
    {
        return $this->accessTime;
    }

    public function setAccessTime(string $accessTime): void
    {
        $this->accessTime = $accessTime;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }
}
