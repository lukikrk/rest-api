<?php

declare(strict_types=1);

namespace App\Shared\Http\Enum;

use App\Shared\Serialization\Format;

enum ContentType: string
{
    public const string NAME = 'Content-Type';

    case json = 'application/json';

    public static function fromFormat(Format $format): ContentType
    {
        return self::{$format->value};
    }
}
