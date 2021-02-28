<?php

namespace App\Entity;

use App\Repository\TransactionsCompleteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionsEnCompleteRepository::class)
 */
class TransactionsComplete extends Transactions
{

}
