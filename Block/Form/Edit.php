<?php

/**
 * A Magento 2 module named Magestat/SigninPhoneNumber
 * Copyright (C) 2019 Magestat
 *
 * This file included in Magestat/SigninWithPhoneNumber is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Magestat\SigninPhoneNumber\Block\Form;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Newsletter\Model\SubscriberFactory;
use Magestat\SigninPhoneNumber\Model\Config\Source\SigninMode;
use Magestat\SigninPhoneNumber\Setup\InstallData;
use Magestat\SigninPhoneNumber\Helper\Data as HelperData;

/**
 * Customer edit form block
 *
 * @api
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 * @since 100.0.2
 */
class Edit extends \Magento\Customer\Block\Form\Edit
{
    /**
     * @var \Magestat\SigninPhoneNumber\Helper\Data
     */
    private $helperData;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param SubscriberFactory $subscriberFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param AccountManagementInterface $customerAccountManagement
     * @param HelperData $helperData
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        SubscriberFactory $subscriberFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,
        HelperData $helperData,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        parent::__construct(
            $context,
            $customerSession,
            $subscriberFactory,
            $customerRepository,
            $customerAccountManagement,
            $data
        );
        $this->helperData = $helperData;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helperData->isActive();
    }

    public function isAlternateIdentfierEditAllowed()
    {
        return $this->helperData->isAlternateIdentifierEditAllowedForCustomer();
    }

    /**
     * Get customer custom phone number attribute as value.
     *
     * @return string Customer phone number value.
     */
    public function getPhoneNumber()
    {
        $phoneAttribute = $this->getCustomer()
            ->getCustomAttribute(InstallData::PHONE_NUMBER);
        return $phoneAttribute ? (string)$phoneAttribute->getValue() : '';
    }

    public function getAlternativeIdentifier()
    {
        $alternativeIdentifierAttribute = $this->getCustomer()
            ->getCustomAttribute(InstallData::ALTERNATIVE_IDENTIFIER);
        return $alternativeIdentifierAttribute ? (string)$alternativeIdentifierAttribute->getValue() : '';
    }

    public function getAlternativeIdentifierEditLabel()
    {
        return $this->scopeConfig->getValue('magestat_signin_phone_number/options/edit_label_for_alternative_identifier');
    }

    public function isAlternateIdentifierMode()
    {
        //compares string to int
        return $this->helperData->getSigninMode() == SigninMode::TYPE_ALTERNATIVE_IDENT_OR_MAIL || $this->helperData->getSigninMode() == SigninMode::TYPE_ALTERNATIVE_IDENT;
    }
}
