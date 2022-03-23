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
namespace Lof\CustomerPassword\Api\Data;

/**
 * Interface PasswordLogInterface
 *
 * @package Lof\CustomerPassword\Api\Data
 */
interface PasswordLogInterface
{

    const ADMIN_USERNAME = 'admin_username';
    const ADMIN_ID = 'admin_id';
    const LOGGED_AT = 'logged_at';
    const PASSWORDLOG_ID = 'passwordlog_id';
    const ADMIN_NAME = 'admin_name';
    const CUSTOMER_EMAIL = 'customer_email';
    const CUSTOMER_ID = 'customer_id';
    const IP = 'ip';

    /**
     * Get passwordlog_id
     *
     * @return string|null
     */
    public function getPasswordlogId();

    /**
     * Set passwordlog_id
     *
     * @param  string $passwordlogId
     *
     * @return PasswordLogInterface
     */
    public function setPasswordlogId($passwordlogId);

    /**
     * Get customer_id
     *
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     *
     * @param  string $customerId
     *
     * @return PasswordLogInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get customer_email
     *
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer_email
     *
     * @param  string $customerEmail
     *
     * @return PasswordLogInterface
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get admin_username
     *
     * @return string|null
     */
    public function getAdminUsername();

    /**
     * Set admin_username
     *
     * @param  string $adminUsername
     *
     * @return PasswordLogInterface
     */
    public function setAdminUsername($adminUsername);

    /**
     * Get admin_id
     *
     * @return string|null
     */
    public function getAdminId();

    /**
     * Set admin_id
     *
     * @param  string $adminId
     *
     * @return PasswordLogInterface
     */
    public function setAdminId($adminId);

    /**
     * Get admin_name
     *
     * @return string|null
     */
    public function getAdminName();

    /**
     * Set admin_name
     *
     * @param string $adminName
     *
     * @return PasswordLogInterface
     */
    public function setAdminName($adminName);

    /**
     * Get ip
     *
     * @return string|null
     */
    public function getIp();

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return PasswordLogInterface
     */
    public function setIp($ip);

    /**
     * Get logged_at
     *
     * @return string|null
     */
    public function getLoggedAt();

    /**
     * Set logged_at
     *
     * @param string $loggedAt
     *
     * @return PasswordLogInterface
     */
    public function setLoggedAt($loggedAt);
}
