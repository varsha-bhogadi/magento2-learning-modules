<?php
namespace MyVendor\MyModule\Plugin;

class AfterFooterPlugin
{

    public function afterGetCopyright(\Magento\Theme\Block\Html\Footer $subject, $result)
    {
        return 'Customized copyright!';
    }
}
