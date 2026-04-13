<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Block\Account;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Adobe\Employee\Api\Data\EmployeeInterface;

class EmployeeForm extends Template
{
    /**
     * @var Registry
     */
    private Registry $registry;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
    }

    /**
     * Get current employee (edit mode)
     */
    public function getCurrentEmployee(): ?EmployeeInterface
    {
        return $this->registry->registry('current_employee');
    }

    /**
     * Save URL
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('employee/account/save');
    }
}