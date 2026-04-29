<?php
declare(strict_types=1);

namespace Adobe\Employee\Controller\Ko;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

class Index implements HttpGetActionInterface
{
    private PageFactory $pageFactory;

    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    public function execute(): Page
    {
        return $this->pageFactory->create();
    }
}