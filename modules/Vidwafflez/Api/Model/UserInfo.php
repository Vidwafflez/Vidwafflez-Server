<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Model;

class UserInfo
{
    public $username;
    public $emailAddress;
    public $encryptedId;

    public function __construct($username, $emailAddress, $encryptedId)
    {
        $this->username = $username;
        $this->emailAddress = $emailAddress;
        $this->encryptedId = $encryptedId;
    }
}