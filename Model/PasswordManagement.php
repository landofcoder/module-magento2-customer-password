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

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerRegistry;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\State\InputMismatchException;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Registry;

/**
 * Class PasswordManagement
 *
 * @package Lof\CustomerPassword\Model
 */
class PasswordManagement
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CustomerRegistry
     */
    protected $customerRegistry;

    /**
     * @var Encryptor
     */
    protected $encryptor;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var PasswordLogFactory
     */
    public $passwordLogFactory;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * PasswordManagement constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerRegistry            $customerRegistry
     * @param Encryptor                   $encryptor
     * @param Registry $registry
     * @param PasswordLogFactory          $passwordLogFactory
     * @param RemoteAddress               $remoteAddress
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerRegistry $customerRegistry,
        Encryptor $encryptor,
        Registry $registry,
        PasswordLogFactory $passwordLogFactory,
        RemoteAddress $remoteAddress
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerRegistry = $customerRegistry;
        $this->encryptor = $encryptor;
        $this->registry = $registry;
        $this->passwordLogFactory = $passwordLogFactory;
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * Change customer password by Email
     *
     * @param  $customerEmail
     * @param  $password
     * @throws InputException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws InputMismatchException
     */
    public function changePassword($customerEmail, $password)
    {
        $customer = $this->customerRepository->get($customerEmail);
        $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
        $customerSecure->setRpToken(null);
        $customerSecure->setRpTokenCreatedAt(null);
        $passwordHash = $this->encryptor->getHash($password, true);
        $customerSecure->setPasswordHash($passwordHash);
        $this->customerRepository->save($customer);
        $this->addPasswordChangeLog($customer);
    }

    /**
     * Change customer password by id
     *
     * @param  $customerId
     * @param  $password
     * @throws InputException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws InputMismatchException
     */
    public function changePasswordById($customerId, $password)
    {
        $customer = $this->customerRepository->getById($customerId);
        $customerSecure = $this->customerRegistry->retrieveSecureData($customer->getId());
        $customerSecure->setRpToken(null);
        $customerSecure->setRpTokenCreatedAt(null);
        $passwordHash = $this->encryptor->getHash($password, true);
        $customerSecure->setPasswordHash($passwordHash);
        $this->customerRepository->save($customer);
        $this->addPasswordChangeLog($customer);
    }

    /**
     * Save customer password change log
     *
     * @param $customer
     */
    public function addPasswordChangeLog($customer)
    {
        $logFactory = $this->passwordLogFactory->create();
        $logFactory->setCustomerId($customer->getId());
        $logFactory->setCustomerEmail($customer->getEmail());

        $adminUser = $this->getAdminUser();
        if ($adminUser) {
            $logFactory->setAdminUsername($adminUser->getUsername());
            $logFactory->setAdminId($adminUser->getId());
            $logFactory->setAdminName($adminUser->getFirstname() . ' ' . $adminUser->getLastname());
            $logFactory->setIp($this->remoteAddress->getRemoteAddress());
        }
        $logFactory->save();
    }

    /**
     * Retrieving current admin detail from registry
     *
     * @return string
     */
    public function getAdminUser()
    {
        return $this->registry->registry('current_admin_user');
    }
}
