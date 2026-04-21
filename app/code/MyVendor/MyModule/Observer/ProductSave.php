<?php
 
namespace MyVendor\MyModule\Observer;
 
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
 
class ProductSave implements ObserverInterface
{
    protected $logger;
 
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger; // Dependency Injection
    }
 
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productName = $product->getName();
 
        $this->logger->info('Product "' . $productName . '" has been saved');
    }
}
