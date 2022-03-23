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
namespace Lof\CustomerPassword\Api;

use Lof\CustomerPassword\Api\Data\PasswordLogInterface;
use Lof\CustomerPassword\Api\Data\PasswordLogSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Interface PasswordLogRepositoryInterface
 *
 * @package Lof\CustomerPassword\Api
 */
interface PasswordLogRepositoryInterface
{
    /**
     * Save PasswordLog
     *
     * @param  PasswordLogInterface $passwordLog
     * @return PasswordLogInterface
     * @throws LocalizedException
     */
    public function save(
        PasswordLogInterface $passwordLog
    );

    /**
     * Retrieve PasswordLog
     *
     * @param  string $passwordlogId
     * @return PasswordLogInterface
     * @throws LocalizedException
     */
    public function getById($passwordlogId);

    /**
     * Retrieve PasswordLog matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return PasswordLogSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );
}
