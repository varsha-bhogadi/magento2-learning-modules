<?php
declare(strict_types=1);

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\Employee\Block\Account;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;
use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Api\Data\EmployeeInterface;

class EmployeeForm extends Template
{
    private RequestInterface $request;
    private EmployeeRepositoryInterface $employeeRepository;
    private ?EmployeeInterface $employee = null;

    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        EmployeeRepositoryInterface $employeeRepository,
        array $data = []
    ) {
        $this->request = $request;
        $this->employeeRepository = $employeeRepository;
        parent::__construct($context, $data);
    }

    public function getEmployee(): ?EmployeeInterface
    {
        if ($this->employee === null) {
            $entityId = (int)$this->request->getParam('entity_id');

            if ($entityId) {
                try {
                    $this->employee = $this->employeeRepository->getById($entityId);
                } catch (\Exception $e) {
                    $this->employee = null;
                }
            }
        }

        return $this->employee;
    }

    public function getFormAction(): string
    {
        return $this->getUrl('employee/account/save');
    }
}
