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
    private ?bool $gdrOptin;
    private ?bool $smsOptin;
    private ?string $name;
    private ?string $surname;
    private ?DateTimeInterface $birthday;
    private ?string $gender;
    private ?string $language;
    private ?string $country;
    private ?string $city;
    /** @var int[]|null */
    private ?array $listId;
    /** @var array<string, mixed>|null */
    private ?array $custom;

    public function __construct(
        ?string            $email,
        ?string            $phoneNumber,
        ?bool              $emailOptin,
        ?bool              $gdrOptin,
        ?bool              $smsOptin,
        ?string            $name,
        ?string            $surname,
        ?DateTimeInterface $birthday,
        ?string            $gender,
        ?string            $language,
        ?string            $country,
        ?string            $city
    )
    {
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->emailOptin = $emailOptin;
        $this->gdrOptin = $gdrOptin;
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

    public function getGdrOptin(): ?bool
    {
        return $this->gdrOptin;
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
        if ($this->gdrOptin !== null) {
            $return['gdr_optin'] = $this->gdrOptin;
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
