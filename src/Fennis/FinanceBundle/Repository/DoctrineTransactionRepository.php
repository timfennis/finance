<?php

declare(strict_types=1);

namespace Fennis\FinanceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Fennis\FinanceBundle\Domain\Transaction;
use PhpOption\Option;
use Ramsey\Uuid\UuidInterface;

/**
 * Class TransactionRepository.
 *
 * @author Tim Fennis <tim@isset.nl>
 */
class DoctrineTransactionRepository extends EntityRepository implements TransactionRepository
{
    public function save(Transaction $transaction)
    {
        $this->getEntityManager()->persist($transaction);
    }

    public function findOneByHash(UuidInterface $hash): Option
    {
        return Option::fromReturn(
            function () use ($hash) {
                return $this->findOneBy(['hash' => $hash]);
            }
        );
    }
}
