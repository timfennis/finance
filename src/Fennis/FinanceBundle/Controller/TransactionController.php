<?php

declare(strict_types=1);

namespace Fennis\FinanceBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;
use Fennis\FinanceBundle\Domain\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TransactionController.
 */
class TransactionController extends Controller
{
    /**
     * @Route(path="/")
     */
    public function indexAction()
    {
        $criteria = Criteria::create();
        $criteria->setMaxResults(100);
        $criteria->orderBy(['transactionDate' => Criteria::DESC]);

        /** @var Transaction[] $transactions */
        $transactions = $this->get('fennis_finance.repository.transaction_repository')->matching($criteria);

        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactions
        ]);
    }
}
