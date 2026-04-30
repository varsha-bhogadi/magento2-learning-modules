<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Adobe\Employee\Model\EmployeeFactory;
use Adobe\Employee\Model\ResourceModel\Employee;

/**
 * Resolver for creating employee
 */
class CreateEmployee implements ResolverInterface
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
        if (empty($args['name'])) {
            throw new GraphQlInputException(__('Name is required.'));
        }

        $employee = $this->employeeFactory->create();
        $employee->setData($args);

        $this->resource->save($employee);

        $data = $employee->getData();
        $data['id'] = $employee->getId();
        return $data;
    }
}