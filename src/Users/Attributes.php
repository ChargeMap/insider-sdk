<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

class Attributes implements JsonSerializable
{
    private ?string $email;
    private ?string $phoneNumber;
    private ?bool $emailOptin;
    private ?bool $gdprOptin;
    private ?bool $smsOptin;
    private ?string $name;
    private ?string $surname;
    private ?DateTimeInterface $birthday;
    private ?string $gender;
    private ?string $language;
    private ?string $country;
    private ?string $city;
    /** @var int[]|null */
    private ?array $listId = null;
    /** @var array<string, mixed>|null */
    private ?array $custom = null;

    public function __construct(
        ?string            $email = null,
        ?string            $phoneNumber = null,
        ?bool              $emailOptin = null,
        ?bool              $gdprOptin = null,
        ?bool              $smsOptin = null,
        ?string            $name = null,
        ?string            $surname = null,
        ?DateTimeInterface $birthday = null,
        ?string            $gender = null,
        ?string            $language = null,
        ?string            $country = null,
        ?string            $city = null
    )
    {
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->emailOptin = $emailOptin;
        $this->gdprOptin = $gdprOptin;
        $this->smsOptin = $smsOptin;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthday = $birthday;
        $this->gender = $gender;
        $this->language = $language;
        $this->country = $country;
        $this->city = $city;
    }

    public function withListId(int $listId): self
    {
        if (empty($this->listId)) {
            $this->listId = [];
        }
        $this->listId[] = $listId;
        return $this;
    }

    public function withCustomAttribute(string $key, $value): self
    {
        if (empty($this->custom)) {
            $this->custom = [];
        }
        $this->custom[$key] = $value;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getEmailOptin(): ?bool
    {
        return $this->emailOptin;
    }

    public function getGdprOptin(): ?bool
    {
        return $this->gdprOptin;
    }

    public function getSmsOptin(): ?bool
    {
        return $this->smsOptin;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return int[]|null
     */
    public function getListId(): ?array
    {
        return $this->listId;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getCustom(): ?array
    {
        return $this->custom;
    }

    public function jsonSerialize(): array
    {
        $return = [];
        if ($this->email !== null) {
            $return['email'] = $this->email;
        }
        if ($this->phoneNumber !== null) {
            $return['phone_number'] = $this->phoneNumber;
        }
        if ($this->emailOptin !== null) {
            $return['email_optin'] = $this->emailOptin;
        }
        if ($this->gdprOptin !== null) {
            $return['gdpr_optin'] = $this->gdprOptin;
        }
        if ($this->smsOptin !== null) {
            $return['sms_optin'] = $this->smsOptin;
        }
        if ($this->name !== null) {
            $return['name'] = $this->name;
        }
        if ($this->surname !== null) {
            $return['surname'] = $this->surname;
        }
        if ($this->birthday !== null) {
            $birthday = (new DateTime())->setTimestamp($this->birthday->getTimestamp());
            $birthday->setTime(0, 0);
            $return['birthday'] = $birthday->format('Y-m-d\TH:i:s\Z');
        }
        if ($this->gender !== null) {
            $return['gender'] = $this->gender;
        }
        if ($this->language !== null) {
            $return['language'] = $this->language;
        }
        if ($this->country !== null) {
            $return['country'] = $this->country;
        }
        if ($this->city !== null) {
            $return['city'] = $this->city;
        }
        if (!empty($this->listId)) {
            $return['list_id'] = $this->listId;
        }
        if (!empty($this->custom)) {
            $return['custom'] = $this->custom;
        }
        return $return;
    }
}
