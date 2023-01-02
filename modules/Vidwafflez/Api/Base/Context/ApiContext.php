<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Base\Context;

use Vidwafflez\Api\Base\Context\ClientName;

class ApiContext
{
    protected ClientName $clientName;
    protected string $clientVersion;

    public function getClientName()
    {
        return $this->clientName;
    }

    public function getClientVersion()
    {
        return $this->clientVersion;
    }
}