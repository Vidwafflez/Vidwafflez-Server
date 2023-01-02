<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Base\Context;

enum ClientName : int
{
    case UNKNOWN_CLIENT    =   0;
    case WEB               =   1;
    case MWEB              =   2;
}