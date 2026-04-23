# Magento 2 Custom Modules Repository

This repository contains custom Magento 2 modules developed as part of training tasks.

## Repository Structure

All modules are located in app/code/Vendor/

### Modules List

- **FeatureToggle** (Task 1): Module with Plugin, Observer, and Preference
  - Admin configuration (Enable/Disable)
  - Plugin: 10% price discount on final price
  - Observer: Logs customer login events
  - Preference: Custom message implementation
  - ACL & Admin menu integration

More modules will be added as tasks are completed.

## Installation Instructions

### Prerequisites
- Magento 2.4.x
- PHP 8.1+
- Composer

### Installation Steps

1. Clone this repository
2. Copy desired module to your Magento installation
3. Enable and install the module:
   php bin/magento module:enable Vendor_ModuleName
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:flush

## Task 1: FeatureToggle Module

### Configuration

Navigate to: Stores - Configuration - Feature Toggle - General

### Testing

Observer logs customer logins to system.log
Plugin applies 10% price discount when enabled

## Author

Varsha Bhogadi

## License

MIT
