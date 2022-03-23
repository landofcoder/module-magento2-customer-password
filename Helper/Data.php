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

namespace Lof\CustomerPassword\Helper;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Authorization\PolicyInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const RESOURCE_ID = "Lof_CustomerPassword::customer_password";
    const CONFIG_ENABLE_PATH = 'customer_password/general/enable';
    const CONFIG_ENABLE_CLI = 'customer_password/general/enable_cli';

    /**
     * @var PolicyInterface
     */
    public $policyInterface;
    /**
     * @var Session
     */
    private $authSession;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param PolicyInterface $policyInterface
     * @param Session $authSession
     */
    public function __construct(
        Context $context,
        PolicyInterface $policyInterface,
        Session $authSession
    ) {
        $this->policyInterface = $policyInterface;
        parent::__construct($context);
        $this->authSession = $authSession;
    }

    /**
     * Whether a module is enabled in the configuration or not
     *
     * @param  string $moduleName Fully-qualified module name
     * @return boolean
     */
    public function isModuleEnabled()
    {
        if ($this->_moduleManager->isEnabled('Lof_CustomerPassword')) {
            if ($this->isEnabled()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Whether a module output is permitted by the configuration or not
     *
     * @param  string $moduleName Fully-qualified module name
     * @return boolean
     */
    public function isOutputEnabled()
    {
        if ($this->_moduleManager->isOutputEnabled('Lof_CustomerPassword')) {
            if ($this->isEnabled()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Whether a module is enabled by the configuration or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        if ($this->scopeConfig->getValue(self::CONFIG_ENABLE_PATH, $storeScope)) {
            return true;
        }
        return false;
    }

    /**
     * Whether a CLI command is enabled by the configuration or not
     *
     * @return bool
     */
    public function isCliEnabled()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        if ($this->scopeConfig->getValue(self::CONFIG_ENABLE_CLI, $storeScope)) {
            return true;
        }
        return false;
    }

    /**
     * @param null $user
     * @return bool
     */
    public function isAllowed($user = null)
    {
        if (!$user) {
            /* @var $currentUser Session */
            $user = $this->authSession->getUser();
        }
        $role = $user->getRole();
        $permission = $this->policyInterface->isAllowed($role->getId(), self::RESOURCE_ID);
        if ($permission) {
            return true;
        }
        return false;
    }

    /**
     * Check password section is enable
     *
     * @return bool
     * @throws LocalizedException
     */
    public function isEnablePasswordSection()
    {
        if ($this->isModuleEnabled() && $this->isOutputEnabled() && $this->isAllowed()) {
            return true;
        }
        return false;
    }

    /**
     * Check password section is enable
     *
     * @return bool
     * @throws LocalizedException
     */
    public function isEnableCliCommand()
    {
        if ($this->isModuleEnabled() && $this->isCliEnabled()) {
            return true;
        }
        return false;
    }
}
