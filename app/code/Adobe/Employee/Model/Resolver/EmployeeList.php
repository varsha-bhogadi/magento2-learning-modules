<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
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
     */
    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ): array {

        // Authentication check
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('Customer not authorized.'));
        }

        // Get collection
        $collection = $this->collectionFactory->create();

        $employees = [];

        foreach ($collection as $item) {
            $employees[] = [
                'id' => (int)$item->getId(),
                'name' => $item->getName(),
                'gender' => $item->getGender(),
                'designation' => $item->getDesignation(),
                'joining_date' => $item->getJoiningDate(),
                'address' => $item->getAddress(),
                'status' => (int)$item->getStatus(),
                'hobbies' => $item->getHobbies()
            ];
        }

        return $employees;
    }
}
