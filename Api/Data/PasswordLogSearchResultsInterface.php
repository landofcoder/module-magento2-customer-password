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

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface PasswordLogSearchResultsInterface
 *
 * @package Lof\CustomerPassword\Api\Data
 */
interface PasswordLogSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get PasswordLog list.
     *
     * @return PasswordLogInterface[]
     */
    public function getItems();

    /**
     * Set customer_id list.
     *
     * @param PasswordLogInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
