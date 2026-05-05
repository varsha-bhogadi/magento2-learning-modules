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
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Adobe\Employee\Api\EmployeeRepositoryInterface;

/**
 * Resolver for fetching employee by ID
 */
class EmployeeById implements ResolverInterface
{
    /**
     * @var EmployeeRepositoryInterface
     */
    private EmployeeRepositoryInterface $employeeRepository;

    /**
     * Constructor
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository
    ) {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Resolve method
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

        // Validate ID
        if (empty($args['id'])) {
            throw new GraphQlInputException(__('Employee ID is required.'));
        }

        try {
            // Fetch using repository
            $employee = $this->employeeRepository->getById((int)$args['id']);
        } catch (\Exception $e) {
            throw new GraphQlNoSuchEntityException(__('Employee not found.'));
        }

        // Return clean response
        return [
            'id' => (int)$employee->getId(),
            'name' => $employee->getName(),
            'gender' => $employee->getGender(),
            'designation' => $employee->getDesignation(),
            'joining_date' => $employee->getJoiningDate(),
            'address' => $employee->getAddress(),
            'status' => (int)$employee->getStatus(),
            'hobbies' => $employee->getHobbies()
        ];
    }
}
