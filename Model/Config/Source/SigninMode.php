<?php

namespace Magestat\SigninPhoneNumber\Model\Config\Source;

/**
 * Class SigninMode
 * Define options to the login process.
 */
class SigninMode
{
    /**
     * @var int Value using phone to sign in.
     */
    const TYPE_PHONE = 1;

    /**
     * @var int Value using phone or email to sign in.
     */
    const TYPE_PHONE_OR_MAIL = 2;

    /**
     * @var int Value using phone or email to sign in.
     */
    const TYPE_ALTERNATIVE_IDENT_OR_MAIL = 3;

    /**
     * Retrieve possible sign in options.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::TYPE_PHONE => __('Sign in Only With Phone and Password'),
            self::TYPE_PHONE_OR_MAIL => __('Sign in With Phone/Email and Password'),
            self::TYPE_ALTERNATIVE_IDENT_OR_MAIL => __('Sign in With alternative Identification/Email and Password'),
        ];
    }
}
