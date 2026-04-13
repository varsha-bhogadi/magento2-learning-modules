<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\Employee\Controller\Account;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Registry;
use Adobe\Employee\Api\EmployeeRepositoryInterface;

class Edit implements HttpGetActionInterface
{
    private PageFactory $pageFactory;
    private RequestInterface $request;
    private EmployeeRepositoryInterface $employeeRepository;
    private RedirectFactory $redirectFactory;
    private Registry $registry;

    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request,
        EmployeeRepositoryInterface $employeeRepository,
        RedirectFactory $redirectFactory,
        Registry $registry
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->employeeRepository = $employeeRepository;
        $this->redirectFactory = $redirectFactory;
        $this->registry = $registry;
    }

    public function execute()
    {
        $id = (int)$this->request->getParam('id');

        if (!$id) {
            return $this->redirectFactory->create()
                ->setPath('employee/account/index');
        }

        try {
            $employee = $this->employeeRepository->getById($id);

            $this->registry->unregister('current_employee');
            $this->registry->register('current_employee', $employee);

        } catch (\Exception $e) {
            return $this->redirectFactory->create()
                ->setPath('employee/account/index');
        }

        return $this->pageFactory->create();
    }
}