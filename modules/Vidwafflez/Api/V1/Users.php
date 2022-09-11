<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\V1;
use Vidwafflez\Api\Base\Api;

use Vidwafflez\Common\Database;
use Vidwafflez\Security\Crypto;
use Vidwafflez\Api\Model\UserInfo;

use PDO;

/**
 * This is mainly a test API, implemented only for the purposes
 * of testing the base interface.
 * 
 * It will most likely be removed in the near future.
 */
class Users
{
    public static function getUserInfo(mixed $req): object
    {
        // Validate request
        if (!Api::validateRequest($req, 
        [
            "userId" => [
                "type" => "int"
            ]
        ]
        )) return Api::reject(Api::getLastInvalidationReason());

        $requestId = (int)$req->userId;

        // Begin response
        $stmt = Database::prepare("SELECT * FROM `users` WHERE `id` = :requestId");
        $stmt->execute([
            "requestId" => $requestId
        ]);
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        // Process data
        $username = $data->username;
        $email = $data->email;
        $encId = Crypto::encryptChannelId($requestId);

        return Api::resolve(new UserInfo($username, $email, $encId));
    }
}