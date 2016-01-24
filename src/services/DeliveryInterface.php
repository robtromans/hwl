<?php

namespace Hwl\Service;

interface DeliveryInterface {

    public function calculateDeliveryDate($date, $plusDays);

    public function getWorkingDays();

    public function modifyWorkingDays(Array $days);

    public function getNextDayDelivery();

    public function getEconomyDelivery();

    public function getNextDayRange();

    public function getEconomyRange();
}