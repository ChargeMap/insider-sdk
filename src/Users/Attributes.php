<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

class Attributes implements JsonSerializable
{
    private ?string $email = null;
    private bool $hasEmailChanged = false;

    private ?string $phoneNumber = null;
    private bool $hasPhoneNumberChanged = false;

    private ?bool $emailOptin = null;
    private bool $hasEmailOptinChanged = false;

    private ?bool $gdprOptin = null;
    private bool $hasGdprOptinChanged = false;

    private ?bool $smsOptin = null;
    private bool $hasSmsOptinChanged = false;

    private ?string $name = null;
    private bool $hasNameChanged = false;

    private ?string $surname = null;
    private bool $hasSurnameChanged = false;

    private ?DateTimeInterface $birthday = null;
    private bool $hasBirthdayChanged = false;

    private ?string $gender = null;
    private bool $hasGenderChanged = false;

    private ?string $language = null;
    private bool $hasLanguageChanged = false;

    private ?string $country = null;
    private bool $hasCountryChanged = false;

    private ?string $city = null;
    private bool $hasCityChanged = false;

    /** @var int[]|null */
    private ?array $listIds = null;
    /** @var array<string, mixed>|null */
    private ?array $customAttributes = null;

    private function __construct()
    {
    }

    public static function builder(): self
    {
        return new self();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function withEmail(?string $email): self
    {
        $clone = clone $this;
        $clone->email = $email;
        $clone->hasEmailChanged = true;
        return $clone;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function withPhoneNumber(?string $phoneNumber): self
    {
        $clone = clone $this;
        $clone->phoneNumber = $phoneNumber;
        $clone->hasPhoneNumberChanged = true;
        return $clone;
    }

    public function getEmailOptin(): ?bool
    {
        return $this->emailOptin;
    }

    public function withEmailOptin(?bool $emailOptin): self
    {
        $clone = clone $this;
        $clone->emailOptin = $emailOptin;
        $clone->hasEmailOptinChanged = true;
        return $clone;
    }

    public function getGdprOptin(): ?bool
    {
        return $this->gdprOptin;
    }

    public function withGdprOptin(?bool $gdprOptin): self
    {
        $clone = clone $this;
        $clone->gdprOptin = $gdprOptin;
        $clone->hasGdprOptinChanged = true;
        return $clone;
    }

    public function getSmsOptin(): ?bool
    {
        return $this->smsOptin;
    }

    public function withSmsOptin(?bool $smsOptin): self
    {
        $clone = clone $this;
        $clone->smsOptin = $smsOptin;
        $clone->hasSmsOptinChanged = true;
        return $clone;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function withName(?string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        $clone->hasNameChanged = true;
        return $clone;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function withSurname(?string $surname): self
    {
        $clone = clone $this;
        $clone->surname = $surname;
        $clone->hasSurnameChanged = true;
        return $clone;
    }

    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    public function withBirthday(?DateTimeInterface $birthday): self
    {
        $clone = clone $this;
        $clone->birthday = $birthday;
        $clone->hasBirthdayChanged = true;
        return $clone;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function withGender(?string $gender): self
    {
        $clone = clone $this;
        $clone->gender = $gender;
        $clone->hasGenderChanged = true;
        return $clone;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function withLanguage(?string $language): self
    {
        $clone = clone $this;
        $clone->language = $language;
        $clone->hasLanguageChanged = true;
        return $clone;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function withCountry(?string $country): self
    {
        $clone = clone $this;
        $clone->country = $country;
        $clone->hasCountryChanged = true;
        return $clone;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function withCity(?string $city): self
    {
        $clone = clone $this;
        $clone->city = $city;
        $clone->hasCityChanged = true;
        return $clone;
    }

    /**
     * @return int[]|null
     */
    public function getListIds(): ?array
    {
        return $this->listIds;
    }

    public function withAddedListId(int $listId): self
    {
        $clone = clone $this;

        if (empty($clone->listIds)) {
            $clone->listIds = [];
        }

        $clone->listIds[] = $listId;
        return $clone;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getCustomAttributes(): ?array
    {
        return $this->customAttributes;
    }

    public function withAddedCustomAttribute(string $key, $value): self
    {
        $clone = clone $this;

        if (empty($clone->customAttributes)) {
            $clone->customAttributes = [];
        }

        $clone->customAttributes[$key] = $value;
        return $clone;
    }

    public function jsonSerialize(): array
    {
        $return = [];

        if ($this->hasEmailChanged) {
            $return['email'] = $this->email;
        }
        
        if ($this->hasPhoneNumberChanged) {
            $return['phone_number'] = $this->phoneNumber;
        }
        
        if ($this->hasEmailOptinChanged) {
            $return['email_optin'] = $this->emailOptin;
        }

        if ($this->hasGdprOptinChanged) {
            $return['gdpr_optin'] = $this->gdprOptin;
        }

        if ($this->hasSmsOptinChanged) {
            $return['sms_optin'] = $this->smsOptin;
        }

        if ($this->hasNameChanged) {
            $return['name'] = $this->name;
        }

        if ($this->hasSurnameChanged) {
            $return['surname'] = $this->surname;
        }

        if ($this->hasBirthdayChanged) {
            $birthday = (new DateTime())->setTimestamp($this->birthday->getTimestamp());
            $birthday->setTime(0, 0);
            $return['birthday'] = $birthday->format('Y-m-d\TH:i:s\Z');
        }

        if ($this->hasGenderChanged) {
            $return['gender'] = $this->gender;
        }

        if ($this->hasLanguageChanged) {
            $return['language'] = $this->language;
        }

        if ($this->hasCountryChanged) {
            $return['country'] = $this->country;
        }

        if ($this->hasCityChanged) {
            $return['city'] = $this->city;
        }

        if (!empty($this->listIds)) {
            $return['list_id'] = $this->listIds;
        }

        if (!empty($this->customAttributes)) {
            $return['custom'] = $this->customAttributes;
        }

        return $return;
    }
}
