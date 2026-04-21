<?php
namespace Vendor\FeatureToggle\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Vendor\FeatureToggle\Helper\Data as ConfigHelper;
use Psr\Log\LoggerInterface;

class CustomerLogin implements ObserverInterface
{
    protected $configHelper;
    protected $logger;

    public function __construct(
        ConfigHelper $configHelper,
        LoggerInterface $logger
    ) {
        $this->configHelper = $configHelper;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        if (!$this->configHelper->isEnabled()) {
            return;
        }

        $customer = $observer->getEvent()->getCustomer();
        
        $this->logger->info('========================================');
        $this->logger->info(
            'FeatureToggle: Customer logged in - ID: ' . $customer->getId() . 
            ' Email: ' . $customer->getEmail()
        );
        $this->logger->info('========================================');
    }
}