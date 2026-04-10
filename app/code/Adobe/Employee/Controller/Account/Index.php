<?php
declare(strict_types=1);
/**
 * Copyright © AdobeEmployee. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\Employee\Controller\Account;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class Index implements HttpGetActionInterface
{
    private PageFactory $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
