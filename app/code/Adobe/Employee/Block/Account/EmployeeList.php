<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Block\Account;

use Magento\Framework\View\Element\Template;
use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;

class EmployeeList extends Template
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get employee collection
     */
    public function getEmployees()
    {
        $collection = $this->collectionFactory->create();

        // Optional improvements (safe defaults)
        $collection->setOrder('entity_id', 'ASC');

        return $collection;
    }
}
