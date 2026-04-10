<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\Employee\Controller\Account;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Adobe\Employee\Api\EmployeeRepositoryInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;

class Delete implements HttpPostActionInterface
{
    private EmployeeRepositoryInterface $repository;
    private RedirectFactory $resultRedirectFactory;
    private Context $context;

    public function __construct(
        Context $context,
        EmployeeRepositoryInterface $repository,
        RedirectFactory $resultRedirectFactory
    ) {
        $this->context = $context;
        $this->repository = $repository;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    public function execute()
    {
        $postData = $this->context->getRequest()->getPostValue();
        $id = isset($postData['entity_id']) ? (int)$postData['entity_id'] : 0;

        $redirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $this->repository->deleteById($id);
                $this->context->getMessageManager()->addSuccessMessage(__('Employee deleted successfully.'));
            } catch (LocalizedException $e) {
                $this->context->getMessageManager()->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->context->getMessageManager()->addErrorMessage(__('Could not delete employee.'));
            }
        } else {
            $this->context->getMessageManager()->addErrorMessage(__('Invalid employee ID.'));
        }

        return $redirect->setPath('*/*/index');
    }
}
