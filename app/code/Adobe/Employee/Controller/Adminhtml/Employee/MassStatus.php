<?php
/**
 * Copyright © Adobe. All rights reserved.
 */

declare(strict_types=1);

namespace Adobe\Employee\Controller\Adminhtml\Employee;

use Adobe\Employee\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Mass Status Controller
 */
class MassStatus extends Action
{
    /**
     * Authorization level
     */
    public const ADMIN_RESOURCE = 'Adobe_Employee::manage_employee';

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param PublisherInterface $publisher
     */
    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly PublisherInterface $publisher
    ) {
        parent::__construct($context);
    }

    /**
     * Execute mass status update
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $status = (int)$this->getRequest()->getParam('status', 0);

        $collection = $this->filter->getCollection(
            $this->collectionFactory->create()
        );

        $updated = 0;

        foreach ($collection as $employee) {
            $message = json_encode([
                'employee_id' => (int)$employee->getId(),
                'status' => $status
            ]);

            $this->publisher->publish(
                'employee.status.topic',
                $message
            );

            $updated++;
        }

        $this->messageManager->addSuccessMessage(
            __('%1 employee(s) added to status update queue.', $updated)
        );

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(
            ResultFactory::TYPE_REDIRECT
        );

        return $resultRedirect->setPath('*/*/');
    }
}
