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

//@codingStandardsIgnoreFile

namespace Lof\CustomerPassword\Ui\Component\Form\Fieldset;

use Lof\CustomerPassword\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Form\Fieldset;

class PasswordSection extends Fieldset
{
    /**
     * CustomerPassword data
     *
     * @var Data
     */
    protected $helper;

    /**
     * PasswordSection constructor.
     * @param ContextInterface $context
     * @param array $components
     * @param array $data
     * @param Data $helper
     */
    public function __construct(
        ContextInterface $context,
        $components = [],
        array $data = [],
        Data $helper
    ) {
        parent::__construct($context, $components, $data);
        $this->helper = $helper;
    }

    /**
     * @throws LocalizedException
     */
    public function prepare()
    {
        parent::prepare();
        if (!$this->helper->isEnablePasswordSection()) {
            $this->_data['config']['componentDisabled'] = true;
        }
    }
}
