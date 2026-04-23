<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Block\Frontend;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Employee Listing Block
 */
class EmployeeListing extends Template
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get REST API URL for employees
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->_urlBuilder->getBaseUrl() . 'rest/V1/employees';
    }

    /**
     * Get component JSON config
     *
     * @return string
     */
    public function getComponentConfig(): string
    {
        return json_encode([
            'apiUrl' => $this->getApiUrl()
        ]);
    }
}