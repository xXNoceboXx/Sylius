<?php

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\DataFixtures\Factory;

use Sylius\Component\Core\Model\CustomerInterface;
use Zenstruck\Foundry\Proxy;

interface WithCustomerInterface
{
    public function withCustomer(Proxy|CustomerInterface|string $customer): static;
}
