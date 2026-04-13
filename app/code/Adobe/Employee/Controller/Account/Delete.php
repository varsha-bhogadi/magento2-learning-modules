<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Controller\Account;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Adobe\Employee\Api\EmployeeRepositoryInterface;

class Delete implements HttpGetActionInterface
{
    private RequestInterface $request;
    private RedirectFactory $redirectFactory;
    private EmployeeRepositoryInterface $employeeRepository;
    private ManagerInterface $messageManager;

    public function __construct(
        RequestInterface $request,
        RedirectFactory $redirectFactory,
        EmployeeRepositoryInterface $employeeRepository,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
        $this->employeeRepository = $employeeRepository;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $resultRedirect = $this->redirectFactory->create();

        $id = (int)$this->request->getParam('id');

        if (!$id) {
            $this->messageManager->addErrorMessage(__('Employee not found.'));
            return $resultRedirect->setPath('employee/account/index');
        }

        try {
            $employee = $this->employeeRepository->getById($id);
            $this->employeeRepository->delete($employee);

            $this->messageManager->addSuccessMessage(__('Employee deleted successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while deleting employee.'));
        }

        return $resultRedirect->setPath('employee/account/index');
    }
}
