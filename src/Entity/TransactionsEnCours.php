<?php

namespace App\Entity;

use App\Repository\TransactionsEnCoursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionsEnCoursRepository::class)
 */
class TransactionsEnCours extends Transactions
{

}
