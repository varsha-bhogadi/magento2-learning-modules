<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\Employee\Model;

use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Api\Data\EmployeeInterface;
use Adobe\Employee\Model\ResourceModel\Employee as ResourceEmployee;
use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Adobe\Employee\Model\EmployeeFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Employee Repository
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    private ResourceEmployee $resource;
    private EmployeeFactory $employeeFactory;
    private CollectionFactory $collectionFactory;

    public function __construct(
        ResourceEmployee $resource,
        EmployeeFactory $employeeFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->resource = $resource;
        $this->employeeFactory = $employeeFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Save employee (Create / Update)
     */
    public function save(EmployeeInterface $employee): EmployeeInterface
    {
        try {
            $model = $this->employeeFactory->create();

            if ($employee->getId()) {
                $this->resource->load($model, $employee->getId());
            }

            $model->setData($employee->getData());

            $this->resource->save($model);

            return $model;

        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save employee: %1', $exception->getMessage())
            );
        }
    }

    /**
     * Update employee by ID
     */
    public function update(int $entityId, EmployeeInterface $employee): EmployeeInterface
    {
        try {
            $model = $this->employeeFactory->create();

            $this->resource->load($model, $entityId);

            if (!$model->getId()) {
                throw new NoSuchEntityException(
                    __('Employee with ID %1 does not exist.', $entityId)
                );
            }

            $model->setData($employee->getData());

            $this->resource->save($model);

            return $model;

        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not update employee: %1', $exception->getMessage())
            );
        }
    }

    /**
     * Get employee by ID
     */
    public function getById(int $entityId): EmployeeInterface
    {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $entityId);

        if (!$employee->getId()) {
            throw new NoSuchEntityException(
                __('Employee with ID %1 does not exist.', $entityId)
            );
        }

        return $employee;
    }

    /**
     * Get list of employees
     */
    public function getList(): array
    {
        $collection = $this->collectionFactory->create();

        return $collection->getItems(); // returns array of models
    }

    /**
     * Delete employee (by object)
     */
    public function delete(EmployeeInterface $employee): bool
    {
        try {
            $model = $this->employeeFactory->create();
            $this->resource->load($model, $employee->getId());

            if (!$model->getId()) {
                throw new NoSuchEntityException(__('Employee does not exist.'));
            }

            $this->resource->delete($model);

        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete employee: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * Delete employee by ID
     */
    public function deleteById(int $entityId): bool
    {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $entityId);

        if (!$employee->getId()) {
            throw new NoSuchEntityException(
                __('Employee with ID %1 does not exist.', $entityId)
            );
        }

        try {
            $this->resource->delete($employee);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete employee: %1', $exception->getMessage())
            );
        }

        return true;
    }
}