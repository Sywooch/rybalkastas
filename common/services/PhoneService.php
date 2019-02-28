<?php

namespace common\services;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;

/**
 *
 * Trait PhoneService
 * @package common\services
 *
 * @author Dmitriy Mosolov
 * @version 1.0 / last modified 28.11.18
 *
 */
class PhoneService
{
    const RUSSIA_ISO3166       = 'RU';
    const AZERBAIJAN_ISO3166   = 'AZ';
    const ARMENIA_ISO3166      = 'AM';
    const BELARUS_ISO3166      = 'BY';
    const KYRGYZSTAN_ISO3166   = 'KG';
    const LATVIA_ISO3166       = 'LV';
    const LITHUANIA_ISO3166    = 'LT';
    const MOLDOVA_ISO3166      = 'MD';
    const TAJIKISTAN_ISO3166   = 'TJ';
    const TURKMENISTAN_ISO3166 = 'TM';
    const UZBEKISTAN_ISO3166   = 'UZ';
    const UKRAINE_ISO3166      = 'UA';
    const ESTONIA_ISO3166      = 'EE';

    //================================================================================================================

    private static $codeValue = [
        self::RUSSIA_ISO3166       => '+7',
        self::AZERBAIJAN_ISO3166   => '+994',
        self::ARMENIA_ISO3166      => '+374',
        self::BELARUS_ISO3166      => '+375',
        self::KYRGYZSTAN_ISO3166   => '+996',
        self::LATVIA_ISO3166       => '+371',
        self::LITHUANIA_ISO3166    => '+370',
        self::MOLDOVA_ISO3166      => '+373',
        self::TAJIKISTAN_ISO3166   => '+992',
        self::TURKMENISTAN_ISO3166 => '+993',
        self::UZBEKISTAN_ISO3166   => '+998',
        self::UKRAINE_ISO3166      => '+380',
        self::ESTONIA_ISO3166      => '+372',
    ];

    private static $codeDescription = [
        self::RUSSIA_ISO3166       => 'Россия / Казахстан +7',
        self::AZERBAIJAN_ISO3166   => 'Азербайджан +994',
        self::ARMENIA_ISO3166      => 'Армения +374',
        self::BELARUS_ISO3166      => 'Беларусь +375',
        self::KYRGYZSTAN_ISO3166   => 'Кыргызстан +996',
        self::LATVIA_ISO3166       => 'Латвия +371',
        self::LITHUANIA_ISO3166    => 'Литва +370',
        self::MOLDOVA_ISO3166      => 'Молдова +373',
        self::TAJIKISTAN_ISO3166   => 'Таджикистан +992',
        self::TURKMENISTAN_ISO3166 => 'Туркменистан +993',
        self::UZBEKISTAN_ISO3166   => 'Узбекистан +998',
        self::UKRAINE_ISO3166      => 'Украина +380',
        self::ESTONIA_ISO3166      => 'Эстония +372',
    ];

    private static $phoneMask = [
        self::RUSSIA_ISO3166       => '+7 9999999999',
        self::AZERBAIJAN_ISO3166   => '+\\9\\94 999999999',
        self::ARMENIA_ISO3166      => '+374 99999999',
        self::BELARUS_ISO3166      => '+375 999999999',
        self::KYRGYZSTAN_ISO3166   => '+\\9\\96 999999999',
        self::LATVIA_ISO3166       => '+371 99999999',
        self::LITHUANIA_ISO3166    => '+370 99999999 ',
        self::MOLDOVA_ISO3166      => '+373 99999999',
        self::TAJIKISTAN_ISO3166   => '+\\9\\92 999999999',
        self::TURKMENISTAN_ISO3166 => '+\\9\\93 99999999 ',
        self::UZBEKISTAN_ISO3166   => '+\\9\\98 999999999',
        self::UKRAINE_ISO3166      => '+380 999999999',
        self::ESTONIA_ISO3166      => '+372 9999999',
    ];

    //================================================================================================================

    public static function getCodesDescription() : array
    {
        return self::$codeDescription;
    }

    public static function getCodesValue() : array
    {
        return self::$codeValue;
    }

    public static function getPhoneMask(): array
    {
        return self::$phoneMask;
    }

    //================================================================================================================

    public static function parsePhone($phone, $code) : PhoneNumber
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            return $parsedPhone = $phoneUtil->parse($phone, $code);
        } catch (NumberParseException $exception) {
            echo $exception->getMessage();
        }
    }

    public static function formatPhone($phone, $code) : string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        return $phoneUtil->format(self::parsePhone($phone, $code), PhoneNumberFormat::INTERNATIONAL);
    }

    public static function isValidNumber($phone, $code) : bool
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        return $phoneUtil->isValidNumber(self::parsePhone($phone, $code));
    }
}
