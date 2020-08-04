<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SupportStatus extends Enum
{
    const OpNew  = 'new';
    const OpOpen = 'open';
    const OpDone = 'done';
}