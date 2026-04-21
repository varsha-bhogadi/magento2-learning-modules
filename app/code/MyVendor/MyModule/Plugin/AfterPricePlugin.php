<?php
namespace MyVendor\MyModule\Plugin;

class AfterPricePlugin
{

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        return $result + 0.5;
    }
}
