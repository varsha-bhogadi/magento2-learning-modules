<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;

/**
 * Resolver for employee list
 */
class EmployeeList implements ResolverInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Resolve employee list
     *
     * @param mixed $field
     * @param mixed $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     */
    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ): array {
        $collection = $this->collectionFactory->create();

        $employees = [];

        foreach ($collection as $item) {
            $data = $item->getData();

            // Map entity_id → id (GraphQL requirement)
            $data['id'] = (int) $item->getId();

            $employees[] = $data;
        }

        return $employees;
    }
}