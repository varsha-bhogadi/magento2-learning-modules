<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Adobe\Employee\Block\Account;

use Magento\Framework\View\Element\Template;
use Adobe\Employee\Api\EmployeeRepositoryInterface;

class EmployeeList extends Template
{
    private EmployeeRepositoryInterface $repository;

    public function __construct(
        Template\Context $context,
        EmployeeRepositoryInterface $repository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->repository = $repository;
    }

    public function getEmployees(): array
    {
        return $this->repository->getList();
    }
}
