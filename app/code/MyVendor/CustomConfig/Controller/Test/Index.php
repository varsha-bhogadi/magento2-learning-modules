<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MyVendor\CustomConfig\Controller\Test;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    private $customConfig;

    public function __construct(
        Context $context,
        \MyVendor\CustomConfig\Model\Config $customConfig
    ) {
        $this->customConfig = $customConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        // Example: Get message for Store ID 2
        $storeId = 2;
        
        // Access data: path is 'messages/{store_id}/message'
        $storeWelcomeMsg = $this->customConfig->get('messages/' . $storeId . '/message');

        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($storeWelcomeMsg);

        return $result;
    }
}
