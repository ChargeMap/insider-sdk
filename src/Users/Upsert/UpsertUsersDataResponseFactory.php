<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users\Upsert;

use stdClass;

class UpsertUsersDataResponseFactory
{
    public static function fromJson(stdClass $json): UpsertUsersDataResponse
    {
        $data = $json->data;
        $fail = $data->fail;
        return new UpsertUsersDataResponse(
            $data->successful->count ?? 0,
            $fail->count ?? 0,
            property_exists($fail, 'errors') ? json_decode(json_encode($fail->errors), true) : [],
        );
    }
}
