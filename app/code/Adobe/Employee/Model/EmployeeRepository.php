<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Model;

use Adobe\Employee\Api\Data\EmployeeInterface;
use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Adobe\Employee\Model\ResourceModel\Employee as EmployeeResource;
use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Employee Repository
 */
class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @var EmployeeResource
     */
    private EmployeeResource $resource;

    /**
     * @var EmployeeFactory
     */
    private EmployeeFactory $employeeFactory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * Constructor
     *
     * @param EmployeeResource $resource
     * @param EmployeeFactory $employeeFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        EmployeeResource $resource,
        EmployeeFactory $employeeFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->resource          = $resource;
        $this->employeeFactory   = $employeeFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Save employee
     *
     * @param EmployeeInterface $employee
     * @return EmployeeInterface
     * @throws CouldNotSaveException
     */
    public function save(
        EmployeeInterface $employee
    ): EmployeeInterface {
        try {
            $this->resource->save($employee);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $employee;
    }

    /**
     * Update employee by ID
     *
     * @param int $entityId
     * @param EmployeeInterface $employee
     * @return EmployeeInterface
     * @throws NoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function update(
        int $entityId,
        EmployeeInterface $employee
    ): EmployeeInterface {
        try {
            $existingEmployee = $this->getById($entityId);

            $existingEmployee->setName(
                $employee->getName()
            );
            $existingEmployee->setGender(
                $employee->getGender()
            );
            $existingEmployee->setDesignation(
                $employee->getDesignation()
            );
            $existingEmployee->setJoiningDate(
                $employee->getJoiningDate()
            );
            $existingEmployee->setAddress(
                $employee->getAddress()
            );
            $existingEmployee->setStatus(
                $employee->getStatus()
            );
            $existingEmployee->setHobbies(
                $employee->getHobbies()
            );

            $this->resource->save($existingEmployee);

        } catch (NoSuchEntityException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $existingEmployee;
    }

    /**
     * Get employee by ID
     *
     * @param int $entityId
     * @return EmployeeInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): EmployeeInterface
    {
        $employee = $this->employeeFactory->create();
        $this->resource->load($employee, $entityId);

        if (!$employee->getId()) {
            throw new NoSuchEntityException(
                __(
                    'Employee with ID %1 does not exist.',
                    $entityId
                )
            );
        }

        return $employee;
    }

    /**
     * Get list of all employees
     *
     * @return EmployeeInterface[]
     */
    public function getList(): array
    {
        $collection = $this->collectionFactory->create();
        $collection->setOrder('entity_id', 'ASC');
        return array_values($collection->getItems());
    }

    /**
     * Delete employee
     *
     * @param EmployeeInterface $employee
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(EmployeeInterface $employee): bool
    {
        try {
            $this->resource->delete($employee);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * Delete employee by ID
     *
     * @param int $entityId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $entityId): bool
    {
        return $this->delete($this->getById($entityId));
    }
}