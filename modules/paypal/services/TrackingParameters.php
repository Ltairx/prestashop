<?php
/**
 * 2007-2022 PayPal
 *
 *  NOTICE OF LICENSE
 *
 *  This source file is subject to the Academic Free License (AFL 3.0)
 *  that is bundled with this package in the file LICENSE.txt.
 *  It is also available through the world-wide-web at this URL:
 *  http://opensource.org/licenses/afl-3.0.php
 *  If you did not receive a copy of the license and are unable to
 *  obtain it through the world-wide-web, please send an email
 *  to license@prestashop.com so we can send you a copy immediately.
 *
 *  DISCLAIMER
 *
 *  Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 *  versions in the future. If you wish to customize PrestaShop for your
 *  needs please refer to http://www.prestashop.com for more information.
 *
 *  @author 2007-2022 PayPal
 *  @author 202 ecommerce <tech@202-ecommerce.com>
 *  @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *  @copyright PayPal
 */

namespace PaypalAddons\services;

use Configuration;
use Exception;
use PaypalAddons\classes\Constants\TrackingParameters as Map;
use PrestaShopLogger;

class TrackingParameters
{
    protected $carrierMap;

    public function __construct()
    {
        try {
            $this->carrierMap = json_decode(Configuration::get(Map::CARRIER_MAP), true);
        } catch (Exception $e) {
        }

        if (false == is_array($this->carrierMap)) {
            $this->carrierMap = [];
        }
    }

    public function getPaypalCarriers()
    {
        return Map::getGermanCarriers();
    }

    public function getPaypalCarrierByPsCarrier($carrierRef)
    {
        if (empty($this->carrierMap[$carrierRef])) {
            return false;
        }

        return $this->carrierMap[$carrierRef];
    }

    public function addCarrierMap($psCarrierRef, $paypalCarrier)
    {
        $this->carrierMap[$psCarrierRef] = $paypalCarrier;
        $this->updateCarrierMap();
    }

    public function setCarrierMap(array $map)
    {
        $this->carrierMap = $map;
        $this->updateCarrierMap();
    }

    protected function updateCarrierMap()
    {
        try {
            return Configuration::updateValue(Map::CARRIER_MAP, json_encode($this->carrierMap));
        } catch (Exception $e) {
            PrestaShopLogger::addLog('[paypal][TrackingParameters::updateCarrierMap()] Error: ' . $e->getMessage());

            return false;
        }
    }

    public function getStatus()
    {
        $status = Configuration::get(Map::STATUS);

        if ($status) {
            return $status;
        }

        return Map::STATUS_SHIPPED;
    }

    public function setStatus($status)
    {
        if ($this->isStatusValid($status)) {
            return Configuration::updateValue(Map::STATUS, $status);
        }

        return false;
    }

    public function getStatusList()
    {
        return Map::getPaypalStatusList();
    }

    public function isStatusValid($status)
    {
        if (false == is_string($status)) {
            return false;
        }

        foreach ($this->getStatusList() as $paypalStatus) {
            if ($paypalStatus['key'] == $status) {
                return true;
            }
        }

        return false;
    }
}
