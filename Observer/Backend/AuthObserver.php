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

use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Backend\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\Validator\Exception;
use Lof\CustomerPassword\Helper\Data;

/**
 * Class AuthObserver
 *
 * @package Lof\CustomerPassword\Observer\Backend
 */
class AuthObserver implements ObserverInterface
{
    const CURRENT_USER_PASSWORD_FIELD = 'admin_password';

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * @var ActionFlag
     */
    protected $actionFlag;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * CustomerPassword data
     *
     * @var Data
     */
    protected $helper;
    /**
     * @var AuthSession
     */
    private $authSession;
    /**
     * @var DataObjectFactory
     */
    private $dataObjectFactory;

    /**
     * AuthObserver constructor.
     *
     * @param Context $context
     * @param Session $session
     * @param Registry $registry
     * @param Data $helper
     * @param AuthSession $authSession
     * @param DataObjectFactory $dataObjectFactory
     */
    public function __construct(
        Context $context,
        Session $session,
        Registry $registry,
        Data $helper,
        AuthSession $authSession,
        DataObjectFactory $dataObjectFactory
    ) {
        $this->messageManager = $context->getMessageManager();
        $this->url = $context->getUrl();
        $this->redirect = $context->getRedirect();
        $this->actionFlag = $context->getActionFlag();
        $this->session = $session;
        $this->registry = $registry;
        $this->helper = $helper;
        $this->context = $context;
        $this->authSession = $authSession;
        $this->dataObjectFactory = $dataObjectFactory;
    }

    /**
     * @param Observer $observer
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        $originalRequestData = $observer->getEvent()->getRequest()->getPostValue();
        $customer = $this->dataObjectFactory->create($originalRequestData['customer']);
        $passwords = $customer->getPasswordSection();
        if (empty($passwords['password']) || !$this->helper->isEnablePasswordSection()) {
            return;
        }

        /* @var Action $controller */
        $controller = $observer->getControllerAction();

        $redirect = 0;
        /* @var $currentUser AuthSession */
        $currentUser = $this->authSession->getUser();

        /* Before updating customer data, ensure that password of current admin user is entered and is correct */
        $currentUserPasswordField = $this::CURRENT_USER_PASSWORD_FIELD;
        $isCurrentUserPasswordValid = isset($passwords[$currentUserPasswordField])
            && !empty($passwords[$currentUserPasswordField]) && is_string($passwords[$currentUserPasswordField]);
        try {
            if (!($isCurrentUserPasswordValid)) {
                throw new AuthenticationException(__('You have entered an invalid password for current admin user.'));
            }
            $currentUser->performIdentityCheck($passwords[$currentUserPasswordField]);
            $this->registry->register('current_admin_user', $currentUser);
        } catch (AuthenticationException $e) {
            $this->messageManager->addError(__('You have entered an invalid password for current admin user.'));
            $redirect = 1;
        } catch (Exception $e) {
            $messages = $e->getMessages();
            $this->messageManager->addMessages($messages);
            $redirect = 1;
        } catch (LocalizedException $e) {
            if ($e->getMessage()) {
                $this->messageManager->addError($e->getMessage());
            }
            $redirect = 1;
        }

        // Redirect to customer edit form
        if ($redirect) {
            $customerId = $customer->getEntityId();
            if ($customerId) {
                $redirectUrl = $this->url->getUrl('customer/*/edit', ['id' => $customerId, '_current' => true]);
            } else {
                $redirectUrl = $this->url->getUrl('customer/*/new', ['_current' => true]);
            }

            $this->session->setCustomerFormData($originalRequestData);
            $this->actionFlag->set('', Action::FLAG_NO_DISPATCH, true);
            $this->redirect->redirect($controller->getResponse(), $redirectUrl);
        }
    }
}
