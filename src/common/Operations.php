<?php
namespace Hwl\Common;

use Hwl\Service\DeliveryService;
use Hwl\Service\GTINService;

class Operations {

    /**
     * @var $deliveryService
     */
    protected $deliveryService;

    /**
     * @var $gtinService
     */
    protected $gtinService;

    /**
     * @var $errors
     */
    protected $errors = array();

    /**
     * @param DeliveryService $deliveryService
     * @param GTINService $gtinService
     */
    public function __construct(DeliveryService $deliveryService, GTINService $gtinService)
    {
        $this->deliveryService = $deliveryService;
        $this->gtinService = $gtinService;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function calculateAvailableDeliveryDates(\DateTime $date)
    {
        try {
            $this->deliveryService->setNextDayDelivery(
                $this->deliveryService->calculateDeliveryDate($date, $this->deliveryService->getNextDayRange())
            );
            $this->deliveryService->setEconomyDelivery(
                $this->deliveryService->calculateDeliveryDate($date, $this->deliveryService->getEconomyRange())
            );
            return true;
        } catch (\Exception $e) {
            $this->logErrors($e->getMessage());
        }
        return false;
    }

    /**
     * @param $digits
     * @return bool
     */
    public function calculateGTIN($digits)
    {
        switch (strlen((string)$digits)) {
            case '7':
                return $this->calculateGTIN8($digits);
            case '11':
                return $this->calculateGTIN12($digits);
            case '12':
                return $this->calculateGTIN13($digits);
            case '13':
                return $this->calculateGTIN14($digits);
        }
        return false;
    }

    /**
     * @return string
     */
    public function getNextDayDelivery()
    {
        return $this->deliveryService->getNextDayDelivery();
    }

    /**
     * @return string
     */
    public function getEconomyDelivery()
    {
        return $this->deliveryService->getEconomyDelivery();
    }

    /**
     * @return mixed
     */
    public function getGTIN8()
    {
        return $this->gtinService->getGtn8();
    }

    /**
     * @return mixed
     */
    public function getGTIN12()
    {
        return $this->gtinService->getGtn12();
    }

    /**
     * @return mixed
     */
    public function getGTIN13()
    {
        return $this->gtinService->getGtn13();
    }

    /**
     * @return mixed
     */
    public function getGTIN14()
    {
        return $this->gtinService->getGtn14();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $digits
     * @return bool
     */
    protected function calculateGTIN8($digits)
    {
        $this->gtinService->setGtn8($this->gtinService->gtn8CheckDigit($digits));
        return true;
    }

    protected function calculateGTIN12($digits)
    {
        $this->gtinService->setGtn12($this->gtinService->gtn12CheckDigit($digits));
        return true;
    }

    protected function calculateGTIN13($digits)
    {
        $this->gtinService->setGtn13($this->gtinService->gtn13CheckDigit($digits));
        return true;
    }

    protected function calculateGTIN14($digits)
    {
        $this->gtinService->setGtn14($this->gtinService->gtn14CheckDigit($digits));
        return true;
    }

    protected function logErrors($error)
    {
        $this->errors[] = $error;
    }
}