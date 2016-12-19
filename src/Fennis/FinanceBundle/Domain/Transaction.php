<?php

declare(strict_types=1);

namespace Fennis\FinanceBundle\Domain;

use DateTime;
use Fennis\FinanceBundle\Entity\BankAccountNumber;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface Transaction.
 *
 * @author Tim Fennis <tim@isset.nl>
 */
interface Transaction
{
    const TRANSACTION_NS = '130bf939-38e5-41b6-8c4a-9a033352627d';

    /**
     * @return BankAccountNumber
     */
    public function getAffectedAccount(): BankAccountNumber;

    /**
     * @return Money
     */
    public function getAmount(): Money;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getMutationType(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return UuidInterface
     */
    public function getHash(): UuidInterface;

    /**
     * @return BankAccountNumber
     */
    public function getOtherAccount(): BankAccountNumber;

    /**
     * @return DateTime
     */
    public function getTransactionDate(): DateTime;
}
