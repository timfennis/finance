<?php

declare(strict_types=1);

namespace Fennis\FinanceBundle\Repository;

use Fennis\FinanceBundle\Domain\Transaction;
use PhpOption\Option;
use Ramsey\Uuid\UuidInterface;

/**
 * Class TransactionRepository.
 *
 * @author Tim Fennis <tim@isset.nl>
 */
interface TransactionRepository
{
    public function save(Transaction $transaction);

    public function findOneByHash(UuidInterface $hash): Option;
}
