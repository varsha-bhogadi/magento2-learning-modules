<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Api\Data\EmployeeInterfaceFactory;

/**
 * Resolver for creating employee
 */
class CreateEmployee implements ResolverInterface
{
    /**
     * @var EmployeeRepositoryInterface
     */
    private EmployeeRepositoryInterface $employeeRepository;

    /**
     * @var EmployeeInterfaceFactory
     */
    private EmployeeInterfaceFactory $employeeFactory;

    /**
     * Constructor
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param EmployeeInterfaceFactory $employeeFactory
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeInterfaceFactory $employeeFactory
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->employeeFactory = $employeeFactory;
    }

    /**
     * Resolve method
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

        // Authentication check
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('Customer not authorized.'));
        }

        // Validation
        if (empty($args['name'])) {
            throw new GraphQlInputException(__('Name is required.'));
        }

        // Create employee object
        $employee = $this->employeeFactory->create();

        // Set data
        foreach ($args as $key => $value) {
            $employee->setData($key, $value);
        }

        // Save using Repository
        $savedEmployee = $this->employeeRepository->save($employee);

        // Return response (clean)
        return [
            'id' => (int)$savedEmployee->getId(),
            'name' => $savedEmployee->getName(),
            'gender' => $savedEmployee->getGender(),
            'designation' => $savedEmployee->getDesignation(),
            'joining_date' => $savedEmployee->getJoiningDate(),
            'address' => $savedEmployee->getAddress(),
            'status' => (int)$savedEmployee->getStatus(),
            'hobbies' => $savedEmployee->getHobbies()
        ];
    }
}
