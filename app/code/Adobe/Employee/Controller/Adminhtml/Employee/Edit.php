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
use Magento\Framework\View\Result\Page;

/**
 * Edit Employee Controller
 */
class Edit extends Action
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
     * Execute edit action
     *
     * @return Page|Redirect
     */
    public function execute(): Page|Redirect
    {
        $entityId = (int) $this->getRequest()->getParam('entity_id');

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if ($entityId) {
            try {
                $employee = $this->employeeRepository->getById($entityId);
                $pageTitle = __('Edit Employee: %1', $employee->getName());
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(
                    __('This employee no longer exists.')
                );
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $pageTitle = __('Add New Employee');
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Adobe_Employee::manage_employee');
        $resultPage->getConfig()->getTitle()->prepend(__('Employees'));
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);

        return $resultPage;
    }
}
