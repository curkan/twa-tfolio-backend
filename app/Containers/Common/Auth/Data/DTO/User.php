<?php

declare(strict_types=1);

namespace App\Containers\Common\Auth\Data\DTO;

class User
{
    public function __construct(
        private ?int $id,
        private ?string $firstName,
        private ?string $lastName,
        private ?string $username,
        private ?string $languageCode,
        private ?bool $allowsWriteToPm,
        private ?string $photoUrl
    ) {}

    /**
     * @param array<string, mixed> $array
     *
     * @return self
     */
    public static function fromArray(array $array): self
    {
        return new self(
            id: $array['id'],
            firstName: $array['first_name'],
            lastName: $array['last_name'],
            username: $array['username'],
            languageCode: $array['language_code'],
            allowsWriteToPm: $array['allows_write_to_pm'] ?? null,
            photoUrl: $array['photo_url'],
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @return bool
     */
    public function getAllowsWriteToPm(): bool
    {
        return $this->allowsWriteToPm;
    }

    /**
     * @return ?string
     */
    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }
}
