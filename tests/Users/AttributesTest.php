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
        $gdrOptin = false;
        $smsOptin = true;
        $name = 'Some Name';
        $surname = 'Some Surname';
        $birthday = new DateTime();
        $gender = 'Female';
        $language = 'EN';
        $country = 'UK';
        $city = 'London';
        $listId = [1, 2, 3];
        $custom = [
            'key' => 'value'
        ];
        $attributes = new Attributes(
            $email,
            $phoneNumber,
            $emailOptin,
            $gdrOptin,
            $smsOptin,
            $name,
            $surname,
            $birthday,
            $gender,
            $language,
            $country,
            $city,
        );
        foreach ($listId as $i) {
            $attributes = $attributes->withListId($i);
        }
        foreach ($custom as $key => $value) {
            $attributes = $attributes->withCustomAttribute($key, $value);
        }
        $this->assertSame($email, $attributes->getEmail());
        $this->assertSame($phoneNumber, $attributes->getPhoneNumber());
        $this->assertSame($emailOptin, $attributes->getEmailOptin());
        $this->assertSame($gdrOptin, $attributes->getGdrOptin());
        $this->assertSame($smsOptin, $attributes->getSmsOptin());
        $this->assertSame($name, $attributes->getName());
        $this->assertSame($surname, $attributes->getSurname());
        $this->assertSame($birthday, $attributes->getBirthday());
        $this->assertSame($gender, $attributes->getGender());
        $this->assertSame($language, $attributes->getLanguage());
        $this->assertSame($country, $attributes->getCountry());
        $this->assertSame($city, $attributes->getCity());
        $this->assertSame($listId, $attributes->getListId());
        $this->assertSame($custom, $attributes->getCustom());
    }

    public function testJsonSerializeWithAllParameters(): void
    {
        $email = 'example@example.com';
        $phoneNumber = '+3312345678';
        $emailOptin = true;
        $gdrOptin = false;
        $smsOptin = true;
        $name = 'Some Name';
        $surname = 'Some Surname';
        $birthday = new DateTime('2022-12-18T09:12:35');
        $gender = 'Female';
        $language = 'EN';
        $country = 'UK';
        $city = 'London';
        $listId = [1, 2, 3];
        $custom = [
            'key' => 'value'
        ];
        $attributes = new Attributes(
            $email,
            $phoneNumber,
            $emailOptin,
            $gdrOptin,
            $smsOptin,
            $name,
            $surname,
            $birthday,
            $gender,
            $language,
            $country,
            $city,
        );
        foreach ($listId as $i) {
            $attributes = $attributes->withListId($i);
        }
        foreach ($custom as $key => $value) {
            $attributes = $attributes->withCustomAttribute($key, $value);
        }

        $this->assertSame(json_encode([
            'email' => $email,
            'phone_number' => $phoneNumber,
            'email_optin' => $emailOptin,
            'gdr_optin' => $gdrOptin,
            'sms_optin' => $smsOptin,
            'name' => $name,
            'surname' => $surname,
            'birthday' => '2022-12-18T00:00:00Z',
            'gender' => $gender,
            'language' => $language,
            'country' => $country,
            'city' => $city,
            'list_id' => $listId,
            'custom' => $custom
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
        $listId = [1, 2, 3];
        $attributes = new Attributes(
            $email,
            null,
            $emailOptin,
            null,
            $smsOptin,
            null,
            $surname,
            null,
            $gender,
            null,
            $country,
            null,
        );
        foreach ($listId as $i) {
            $attributes = $attributes->withListId($i);
        }

        $this->assertSame(json_encode([
            'email' => $email,
            'email_optin' => $emailOptin,
            'sms_optin' => $smsOptin,
            'surname' => $surname,
            'gender' => $gender,
            'country' => $country,
            'list_id' => $listId,
        ]), json_encode($attributes));
    }
}
