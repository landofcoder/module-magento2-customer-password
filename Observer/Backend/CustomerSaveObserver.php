<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_CustomerPassword
 * @copyright  Copyright (c) 2022 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\CustomerPassword\Observer\Backend;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Lof\CustomerPassword\Model\PasswordManagement;
use Lof\CustomerPassword\Helper\Data;

/**
 * Class CustomerSaveObserver
 *
 * @package Lof\CustomerPassword\Observer\Backend
 */
class CustomerSaveObserver implements ObserverInterface
{
    /**
     * @var PasswordManagement
     */
    protected $passwordManagement;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Current customer
     */
    private $customer;

    /**
     * CustomerPassword data
     *
     * @var Data
     */
    protected $helper;

    /**
     * CustomerSaveObserver constructor.
     *
     * @param Context            $context
     * @param PasswordManagement $passwordManagement
     * @param Data               $helper
     */
    public function __construct(
        Context $context,
        PasswordManagement $passwordManagement,
        Data $helper
    ) {
        $this->passwordManagement = $passwordManagement;
        $this->messageManager = $context->getMessageManager();
        $this->helper = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if (!$this->helper->isEnablePasswordSection()) {
            return;
        }
        $this->customer = $observer->getData('customer');
        $customer = $observer->getData('request')->getParam('customer');

        try {
            $customerId = $this->customer->getId();
            $passwords = isset($customer['password_section']) ? $customer['password_section'] : '';

            $password = isset($passwords['password']) ? $passwords['password'] : '';
            if (empty($password)) {
                return;
            }
            if (!$customerId) {
                throw new LocalizedException(
                    __('Customer ID should be specified.')
                );
            }
            $this->passwordManagement->changePasswordById($customerId, $password);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
    }
}
