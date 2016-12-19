<?php

namespace Fennis\FinanceBundle\Domain;

/**
 * Interface Transaction.
 *
 * @author Tim Fennis <tim@isset.nl>
 */
interface Transaction
{
    const TRANSACTION_NS = '130bf939-38e5-41b6-8c4a-9a033352627d';

    public function getHash();
}