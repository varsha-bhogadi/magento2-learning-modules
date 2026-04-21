<?php

namespace MyVendor\MyModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;

class Log implements ObserverInterface
{
    private $logger;
    private $request;

    public function __construct(
        LoggerInterface $logger,
        RequestInterface $request
    ) {
        $this->logger = $logger;
        $this->request = $request;
    }

    public function execute(Observer $observer)
    {
        $this->logger->critical(
            'Request URI: ' . $this->request->getPathInfo()
        );
    }
}
