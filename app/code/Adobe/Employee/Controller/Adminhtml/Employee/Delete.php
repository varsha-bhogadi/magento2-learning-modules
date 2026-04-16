<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Controller\Adminhtml\Employee;

use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete Employee Controller
 */
class Delete extends Action
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
     * Constructor
     *
     * @param Context $context
     * @param EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(
        Context $context,
        EmployeeRepositoryInterface $employeeRepository
    ) {
        parent::__construct($context);
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Execute delete action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $entityId = (int) $this->getRequest()->getParam('entity_id');

        if (!$entityId) {
            $this->messageManager->addErrorMessage(
                __('Invalid employee ID.')
            );
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $this->employeeRepository->deleteById($entityId);
            $this->messageManager->addSuccessMessage(
                __('The employee has been deleted successfully.')
            );
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(
                __('The employee no longer exists.')
            );
        } catch (CouldNotDeleteException $e) {
            $this->messageManager->addErrorMessage(
                __('Could not delete the employee. Please try again.')
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
