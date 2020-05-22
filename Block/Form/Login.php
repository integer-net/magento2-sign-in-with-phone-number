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

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url;
use Magestat\SigninPhoneNumber\Helper\Data as HelperData;
use Magestat\SigninPhoneNumber\Model\Config\Source\SigninMode;

/**
 * Customer login form block
 *
 * @api
 * @since 100.0.2
 */
class Login extends \Magento\Customer\Block\Form\Login
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
     * @param Url $customerUrl
     * @param HelperData $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Url $customerUrl,
        HelperData $helperData,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $customerUrl, $data);
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

    /**
     * @return object
     */
    public function getMode()
    {
        switch ($this->helperData->getSigninMode()) {
            case SigninMode::TYPE_PHONE:
                $mode = $this->modePhone();
                break;
            case SigninMode::TYPE_PHONE_OR_MAIL:
                $mode = $this->modePhoneOrMail();
                break;
            case SigninMode::TYPE_ALTERNATIVE_IDENT_OR_MAIL:
                $mode = $this->modeAlternativeIdentfierOrMail();
        }
        return $this->addData($mode);
    }

    /**
     * List of parameters to be used in form as phone mode.
     *
     * @return array
     */
    private function modePhone()
    {
        return [
            'note' => $this->escapeHtml(
                __('If you have an account, sign in with your phone number.')
            ),
            'label' => $this->escapeHtml(__('Phone Number')),
            'title' => $this->escapeHtmlAttr(__('Phone Number'))
        ];
    }

    /**
     * List of parameters to be used in form as phone and email mode.
     *
     * @return array
     */
    private function modePhoneOrMail()
    {
        return [
            'note' => $this->escapeHtml(
                __('If you have an account, sign in with your email address or phone number.')
            ),
            'label' => $this->escapeHtml(__('Email Address or Phone Number')),
            'title' => $this->escapeHtmlAttr(__('Email or Phone'))
        ];
    }

    private function modeAlternativeIdentfierOrMail()
    {
        $label = $this->scopeConfig->getValue('magestat_signin_phone_number/options/label_for_alternative_identifier');
        $note = $this->scopeConfig->getValue('magestat_signin_phone_number/options/note_for_alternative_identifier');
        $title = $this->scopeConfig->getValue('magestat_signin_phone_number/options/title_for_alternative_identifier');
        return [
            'note' => $this->escapeHtml(
                __($note)
            ),
            'label' => $this->escapeHtml(__($label)),
            'title' => $this->escapeHtmlAttr(__($title))
        ];
    }
}
