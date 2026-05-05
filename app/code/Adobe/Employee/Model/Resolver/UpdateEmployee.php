<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
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
 * Resolver for updating employee
 */
class UpdateEmployee implements ResolverInterface
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
            // Get employee using repository
            $employee = $this->employeeRepository->getById((int)$args['id']);
        } catch (\Exception $e) {
            throw new GraphQlNoSuchEntityException(__('Employee not found.'));
        }

        // Update only provided fields
        foreach ($args as $key => $value) {
            if ($key !== 'id' && $value !== null) {
                $employee->setData($key, $value);
            }
        }

        //Save using repository
        $updatedEmployee = $this->employeeRepository->save($employee);

        // Return clean response
        return [
            'id' => (int)$updatedEmployee->getId(),
            'name' => $updatedEmployee->getName(),
            'gender' => $updatedEmployee->getGender(),
            'designation' => $updatedEmployee->getDesignation(),
            'joining_date' => $updatedEmployee->getJoiningDate(),
            'address' => $updatedEmployee->getAddress(),
            'status' => (int)$updatedEmployee->getStatus(),
            'hobbies' => $updatedEmployee->getHobbies()
        ];
    }
}
