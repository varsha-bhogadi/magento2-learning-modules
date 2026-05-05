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
 * Resolver for deleting employee
 */
class DeleteEmployee implements ResolverInterface
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
    ): bool {

        // Authentication check
        if (!$context->getUserId()) {
            throw new GraphQlAuthorizationException(__('Customer not authorized.'));
        }

        // Validate ID
        if (empty($args['id'])) {
            throw new GraphQlInputException(__('Employee ID is required.'));
        }

        try {
            // Delete using repository
            $this->employeeRepository->deleteById((int)$args['id']);
        } catch (\Exception $e) {
            throw new GraphQlNoSuchEntityException(__('Employee not found.'));
        }

        return true;
    }
}
