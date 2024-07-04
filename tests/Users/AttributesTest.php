<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users;

use Chargemap\InsiderSdk\Users\Attributes;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\Users\Attributes
 */
class AttributesTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $email = 'example@example.com';
        $phoneNumber = '+3312345678';
        $emailOptin = true;
        $gdprOptin = false;
        $smsOptin = true;
        $name = 'Some Name';
        $surname = 'Some Surname';
        $birthday = new DateTime();
        $gender = 'Female';
        $language = 'EN';
        $country = 'UK';
        $city = 'London';
        $listIds = [1, 2, 3];
        $customAttributes = ['key' => 'value'];

        $attributes = Attributes::builder()
            ->withEmail($email)
            ->withPhoneNumber($phoneNumber)
            ->withEmailOptin($emailOptin)
            ->withGdprOptin($gdprOptin)
            ->withSmsOptin($smsOptin)
            ->withName($name)
            ->withSurname($surname)
            ->withBirthday($birthday)
            ->withGender($gender)
            ->withLanguage($language)
            ->withCountry($country)
            ->withCity($city);

        $this->assertSame($email, $attributes->getEmail());
        $this->assertSame($phoneNumber, $attributes->getPhoneNumber());
        $this->assertSame($emailOptin, $attributes->getEmailOptin());
        $this->assertSame($gdprOptin, $attributes->getGdprOptin());
        $this->assertSame($smsOptin, $attributes->getSmsOptin());
        $this->assertSame($name, $attributes->getName());
        $this->assertSame($surname, $attributes->getSurname());
        $this->assertSame($birthday, $attributes->getBirthday());
        $this->assertSame($gender, $attributes->getGender());
        $this->assertSame($language, $attributes->getLanguage());
        $this->assertSame($country, $attributes->getCountry());
        $this->assertSame($city, $attributes->getCity());
        $this->assertNull($attributes->getListIds());
        $this->assertNull($attributes->getCustomAttributes());

        foreach ($listIds as $listId) {
            $attributes = $attributes->withAddedListId($listId);
        }
        foreach ($customAttributes as $key => $value) {
            $attributes = $attributes->withAddedCustomAttribute($key, $value);
        }

        $this->assertSame($listIds, $attributes->getListIds());
        $this->assertSame($customAttributes, $attributes->getCustomAttributes());
    }

    public function testJsonSerializeWithAllParameters(): void
    {
        $email = 'example@example.com';
        $phoneNumber = '+3312345678';
        $emailOptin = true;
        $gdprOptin = false;
        $smsOptin = true;
        $name = 'Some Name';
        $surname = 'Some Surname';
        $birthday = new DateTime('2022-12-18T09:12:35');
        $gender = 'Female';
        $language = 'EN';
        $country = 'UK';
        $city = 'London';
        $listIds = [1, 2, 3];
        $customAttributes = ['key' => 'value'];

        $attributes = Attributes::builder()
            ->withEmail($email)
            ->withPhoneNumber($phoneNumber)
            ->withEmailOptin($emailOptin)
            ->withGdprOptin($gdprOptin)
            ->withSmsOptin($smsOptin)
            ->withName($name)
            ->withSurname($surname)
            ->withBirthday($birthday)
            ->withGender($gender)
            ->withLanguage($language)
            ->withCountry($country)
            ->withCity($city);

        foreach ($listIds as $listId) {
            $attributes = $attributes->withAddedListId($listId);
        }
        foreach ($customAttributes as $key => $value) {
            $attributes = $attributes->withAddedCustomAttribute($key, $value);
        }

        $this->assertSame(json_encode([
            'email' => $email,
            'phone_number' => $phoneNumber,
            'email_optin' => $emailOptin,
            'gdpr_optin' => $gdprOptin,
            'sms_optin' => $smsOptin,
            'name' => $name,
            'surname' => $surname,
            'birthday' => '2022-12-18T00:00:00Z',
            'gender' => $gender,
            'language' => $language,
            'country' => $country,
            'city' => $city,
            'list_id' => $listIds,
            'custom' => $customAttributes
        ]), json_encode($attributes));
    }

    public function testPartialJsonSerialize(): void
    {
        $email = 'example@example.com';
        $emailOptin = true;
        $smsOptin = true;
        $surname = 'Some Surname';
        $gender = 'Female';
        $country = 'UK';
        $listIds = [1, 2, 3];

        $attributes = Attributes::builder()
            ->withEmail($email)
            ->withEmailOptin($emailOptin)
            ->withSmsOptin($smsOptin)
            ->withSurname($surname)
            ->withGender($gender)
            ->withCountry($country);

        foreach ($listIds as $listId) {
            $attributes = $attributes->withAddedListId($listId);
        }

        $this->assertSame(json_encode([
            'email' => $email,
            'email_optin' => $emailOptin,
            'sms_optin' => $smsOptin,
            'surname' => $surname,
            'gender' => $gender,
            'country' => $country,
            'list_id' => $listIds,
        ]), json_encode($attributes));
    }
}
