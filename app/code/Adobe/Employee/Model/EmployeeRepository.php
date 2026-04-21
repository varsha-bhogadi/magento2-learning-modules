<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model;

use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Api\Data\EmployeeInterface;
use Adobe\Employee\Model\EmployeeFactory;
use Adobe\Employee\Model\ResourceModel\Employee as ResourceEmployee;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @var ResourceEmployee
     */
    private ResourceEmployee $resource;

    /**
     * @var EmployeeFactory
     */
    private EmployeeFactory $employeeFactory;

    public function __construct(
        ResourceEmployee $resource,
        EmployeeFactory $employeeFactory
    ) {
        $this->resource = $resource;
        $this->employeeFactory = $employeeFactory;
    }

    /**
     * Save Employee
     */
    public function save(EmployeeInterface $employee): EmployeeInterface
    {
        try {
            $this->resource->save($employee);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('Could not save Employee: %1', $e->getMessage())
            );
        }

        return $employee;
    }

    /**
     * Get Employee by ID
     */
    public function getById(int $id): EmployeeInterface
    {
        $employee = $this->employeeFactory->create();

        $this->resource->load($employee, $id);

        if (!$employee->getId()) {
            throw new NoSuchEntityException(
                __('Employee with ID "%1" does not exist.', $id)
            );
        }

        return $employee;
    }

    /**
     * Delete Employee
     */
    public function delete(EmployeeInterface $employee): bool
    {
        try {
            $this->resource->delete($employee);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('Could not delete Employee: %1', $e->getMessage())
            );
        }

        return true;
    }

    /**
     * Delete by ID
     */
    public function deleteById(int $id): bool
    {
        $employee = $this->getById($id);
        return $this->delete($employee);
    }
}
