<?php

declare(strict_types=1);

namespace Setono\SyliusMailChimpPlugin\Repository;

use Sylius\Component\Core\Model\CustomerInterface;

interface CustomerRepositoryInterface
{
    /**
     * @return CustomerInterface[]
     */
    public function findNonExportedCustomers(): array;

    /**
     * @return CustomerInterface[]
     */
    public function findAll(): array;
}
