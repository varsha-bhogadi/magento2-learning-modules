<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Controller\Adminhtml\Employee;

use Adobe\Employee\Api\Data\EmployeeInterfaceFactory;
use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Save Employee Controller
 */
class Save extends Action
{
    /**
     * Authorization level
     */
    public const ADMIN_RESOURCE = 'Adobe_Employee::manage_employee';

    /**
     * @var EmployeeRepositoryInterface
     */
    private EmployeeRepositoryInterface $employeeRepository;

    /**
     * @var EmployeeInterfaceFactory
     */
    private EmployeeInterfaceFactory $employeeFactory;

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * Constructor
     *
     * @param Context $context
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param EmployeeInterfaceFactory $employeeFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeInterfaceFactory $employeeFactory,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->employeeRepository = $employeeRepository;
        $this->employeeFactory = $employeeFactory;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Execute save action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(
            ResultFactory::TYPE_REDIRECT
        );

        $postData = $this->getRequest()->getPostValue();

        if (empty($postData)) {
            return $resultRedirect->setPath('*/*/');
        }

        $entityId = isset($postData['entity_id'])
            ? (int) $postData['entity_id']
            : null;

        try {
            if ($entityId) {
                $employee = $this->employeeRepository->getById($entityId);
            } else {
                $employee = $this->employeeFactory->create();
            }

            $employee->setName($postData['name'] ?? '');
            $employee->setGender($postData['gender'] ?? '');
            $employee->setDesignation($postData['designation'] ?? '');
            $employee->setJoiningDate($postData['joining_date'] ?? '');
            $employee->setAddress($postData['address'] ?? '');
            $hobbies = $postData['hobbies'] ?? [];
            if (is_array($hobbies)) {
                $employee->setHobbies(implode(',', $hobbies));
            } else {
                $employee->setHobbies($hobbies);
            }
            $employee->setStatus((int) ($postData['status'] ?? 1));

            $this->employeeRepository->save($employee);

            $this->messageManager->addSuccessMessage(
                __('The employee has been saved successfully.')
            );

            $this->dataPersistor->clear('adobe_employee');

            if (isset($postData['back']) && $postData['back'] === 'edit') {
                return $resultRedirect->setPath(
                    '*/*/edit',
                    ['entity_id' => $employee->getId()]
                );
            }

            return $resultRedirect->setPath('*/*/');

        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(
                __('This employee no longer exists.')
            );
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(
                __('Could not save the employee. Please try again.')
            );
            $this->dataPersistor->set('adobe_employee', $postData);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['entity_id' => $entityId]
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('An error occurred while saving. Please try again.')
            );
            $this->dataPersistor->set('adobe_employee', $postData);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['entity_id' => $entityId]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
