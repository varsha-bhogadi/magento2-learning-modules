<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Adobe\Employee\Model\EmployeeFactory;
use Adobe\Employee\Model\ResourceModel\Employee;

/**
 * Resolver for fetching employee by ID
 */
class EmployeeById implements ResolverInterface
{
    private EmployeeFactory $employeeFactory;
    private Employee $resource;

    public function __construct(
        EmployeeFactory $employeeFactory,
        Employee $resource
    ) {
        $this->employeeFactory = $employeeFactory;
        $this->resource = $resource;
    }

    public function resolve(
        $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ): array {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, (int)$args['id']);

        if (!$employee->getId()) {
            throw new GraphQlNoSuchEntityException(__('Employee not found.'));
        }


        $data = $employee->getData();
        $data['id'] = $employee->getId();
        return $data;
    }
}