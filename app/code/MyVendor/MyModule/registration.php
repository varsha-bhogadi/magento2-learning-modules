<?php
//register function registers module with magentophp bin/magento module:enable
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,  //this is module like type of component
    'MyVendor_MyModule',   //module name
    __DIR__
);
