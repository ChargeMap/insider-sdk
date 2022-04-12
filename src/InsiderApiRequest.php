<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

interface InsiderApiRequest
{
    public function getHostType(): InsiderApiHostType;
}
