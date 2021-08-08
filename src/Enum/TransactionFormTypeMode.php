<?php

declare(strict_types=1);

namespace App\Enum;

use Spatie\Enum\Enum;

/**
 * @method static self DEPOSIT()
 * @method static self WITHDRAW()
 * @method static self TRANSFER()
 * @method static self SEPA()
 */
final class TransactionFormTypeMode extends Enum
{
}
