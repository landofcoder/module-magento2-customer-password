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
namespace Lof\CustomerPassword\Model;

use Lof\CustomerPassword\Api\Data\PasswordLogInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class PasswordLog
 *
 * @package Lof\CustomerPassword\Model
 */
class PasswordLog extends AbstractModel implements PasswordLogInterface
{

    protected $_eventPrefix = 'lof_customer_password_log';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\PasswordLog::class);
    }

    /**
     * Get passwordlog_id
     *
     * @return string
     */
    public function getPasswordlogId()
    {
        return $this->getData(self::PASSWORDLOG_ID);
    }

    /**
     * Set passwordlog_id
     *
     * @param  string $passwordlogId
     *
     * @return PasswordLogInterface
     */
    public function setPasswordlogId($passwordlogId)
    {
        return $this->setData(self::PASSWORDLOG_ID, $passwordlogId);
    }

    /**
     * Get customer_id
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     *
     * @param  string $customerId
     *
     * @return PasswordLogInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get customer_email
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * Set customer_email
     *
     * @param  string $customerEmail
     *
     * @return PasswordLogInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get admin_username
     *
     * @return string
     */
    public function getAdminUsername()
    {
        return $this->getData(self::ADMIN_USERNAME);
    }

    /**
     * Set admin_username
     *
     * @param  string $adminUsername
     *
     * @return PasswordLogInterface
     */
    public function setAdminUsername($adminUsername)
    {
        return $this->setData(self::ADMIN_USERNAME, $adminUsername);
    }

    /**
     * Get admin_id
     *
     * @return string
     */
    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
    }

    /**
     * Set admin_id
     *
     * @param  string $adminId
     *
     * @return PasswordLogInterface
     */
    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * Get admin_name
     *
     * @return string
     */
    public function getAdminName()
    {
        return $this->getData(self::ADMIN_NAME);
    }

    /**
     * Set admin_name
     *
     * @param string $adminName
     *
     * @return PasswordLogInterface
     */
    public function setAdminName($adminName)
    {
        return $this->setData(self::ADMIN_NAME, $adminName);
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->getData(self::IP);
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return PasswordLogInterface
     */
    public function setIp($ip)
    {
        return $this->setData(self::IP, $ip);
    }

    /**
     * Get logged_at
     *
     * @return string
     */
    public function getLoggedAt()
    {
        return $this->getData(self::LOGGED_AT);
    }

    /**
     * Set logged_at
     *
     * @param string $loggedAt
     *
     * @return PasswordLogInterface
     */
    public function setLoggedAt($loggedAt)
    {
        return $this->setData(self::LOGGED_AT, $loggedAt);
    }
}
