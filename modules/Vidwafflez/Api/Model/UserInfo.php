<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Model;

class UserInfo
{
    public string $username;
    public string $emailAddress;
    public string $encryptedId;

    public function __construct(string $username, string $emailAddress, 
                                string $encryptedId)
    {
        $this->username = $username;
        $this->emailAddress = $emailAddress;
        $this->encryptedId = $encryptedId;
    }
}