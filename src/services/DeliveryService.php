<?php

namespace Hwl\Service;

class DeliveryService implements DeliveryInterface {

    /**
     * @var array
     */
    protected $workingDays = array(
        'monday', 'tuesday', 'wednesday', 'thursday', 'friday'
    );

    /**
     * @var string
     */
    protected $nextDayDelivery;

    /**
     * @var string
     */
    protected $economyDelivery;

    /**
     * @var int
     */
    public $economyRange = 3;

    /**
     * @var int
     */
    public $nextDayRange = 1;

    /**
     * @var string
     */
    public $dateFormat = 'd-m-Y';

    /**
     * @param $date
     * @param $plusDays
     * @return mixed
     * @throws \Exception
     */
    public function calculateDeliveryDate($date, $plusDays)
    {
        if (count($this->workingDays)) {
            $copyDate = clone $date;
            $i = 0;
            while ($plusDays > $i) {
                $nextDay = strtolower($copyDate->modify("+1 day")->format('l'));
                if (!in_array($nextDay, $this->workingDays)) {
                    continue;
                }
                $i++;
            }
            return $copyDate->format($this->dateFormat);
        }
        throw new \Exception('No days available.');
    }

    /**
     * @return array
     */
    public function getWorkingDays()
    {
        return $this->workingDays;
    }

    /**
     * @param array $days
     * @throws \Exception
     */
    public function modifyWorkingDays(Array $days)
    {
        $this->workingDays = $this->parseSuppliedWorkingDays($days);
    }

    /**
     * @param $date
     */
    public function setNextDayDelivery($date)
    {
        $this->nextDayDelivery = $date;
    }

    /**
     * @return string
     */
    public function getNextDayDelivery()
    {
        return $this->nextDayDelivery;
    }

    /**
     * @param $date
     */
    public function setEconomyDelivery($date)
    {
        $this->economyDelivery = $date;
    }

    /**
     * @return string
     */
    public function getEconomyDelivery()
    {
        return $this->economyDelivery;
    }

    /**
     * @return int
     */
    public function getNextDayRange()
    {
        return $this->nextDayRange;
    }

    /**
     * @return int
     */
    public function getEconomyRange()
    {
        return $this->economyRange;
    }

    /**
     * @param $days
     * @return mixed
     * @throws \Exception
     */
    protected function parseSuppliedWorkingDays($days)
    {
        if (count($days)) {
            foreach ($days as $day) {
                if (strtolower(date('l', strtotime($day))) !== strtolower($day)) {
                    throw new \Exception('Supplied working days must contain valid days.');
                }
            }
        }
        return $days;
    }
}