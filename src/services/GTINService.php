<?php
namespace Hwl\Service;

/**
 * Calculations based on
 * gs1.org/how-calculate-check-digit-manually
 *
 * Class GTINService
 * @package Hwl\Service
 */

class GTINService {

    protected $gtn8;

    protected $gtn12;

    protected $gtn13;

    protected $gtn14;

    /**
     * @param $digits
     * @return string
     * @throws \Exception
     */
    public function gtn8CheckDigit($digits)
    {
        $digits = $this->parseDigits($digits, 7);
        $sum = $this->getTotalSumForGtn8CheckDigit($digits);
        return $digits . $this->subtractSumFromNearestOrHigherTen($sum);
    }

    /**
     * @param $digits
     * @return string
     * @throws \Exception
     */
    public function gtn12CheckDigit($digits)
    {
        $digits = $this->parseDigits($digits, 11);
        $sum = $this->getTotalSumForGtn12CheckDigit($digits);
        return $digits . $this->subtractSumFromNearestOrHigherTen($sum);
    }

    /**
     * @param $digits
     * @return string
     * @throws \Exception
     */
    public function gtn13CheckDigit($digits)
    {
        $digits = $this->parseDigits($digits, 12);
        $sum = $this->getTotalSumForGtn13CheckDigit($digits);
        return $digits . $this->subtractSumFromNearestOrHigherTen($sum);
    }

    /**
     * @param $digits
     * @return string
     * @throws \Exception
     */
    public function gtn14CheckDigit($digits)
    {
        $digits = $this->parseDigits($digits, 13);
        $sum = $this->getTotalSumForGtn14CheckDigit($digits);
        return $digits . $this->subtractSumFromNearestOrHigherTen($sum);
    }

    /**
     * @param $sum
     * @return float
     */
    public function getNearestTenFromSum($sum)
    {
        return (ceil($sum / 10) *10);
    }

    public function setGtn8($digits)
    {
        $this->gtn8 = $digits;
    }

    public function getGtn8()
    {
        return $this->gtn8;
    }

    public function setGtn12($digits)
    {
        $this->gtn12 = $digits;
    }

    public function getGtn12()
    {
        return $this->gtn12;
    }

    public function setGtn13($digits)
    {
        $this->gtn13 = $digits;
    }

    public function getGtn13()
    {
        return $this->gtn13;
    }

    public function setGtn14($digits)
    {
        $this->gtn14 = $digits;
    }

    public function getGtn14()
    {
        return $this->gtn14;
    }

    /**
     * @param $digits
     * @return mixed
     */
    protected function getTotalSumForGtn8CheckDigit($digits)
    {
        $evenSum = ($digits[1] + $digits[3] + $digits[5]);
        $oddSum = ($digits[0] + $digits[2] + $digits[4] + $digits[6]);
        return ($evenSum + ($oddSum * 3));
    }

    /**
     * @param $digits
     * @return mixed
     */
    protected function getTotalSumForGtn12CheckDigit($digits)
    {
        $evenSum = ($digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9]);
        $oddSum = ($digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10]);
        return ($evenSum + ($oddSum * 3));
    }

    /**
     * @param $digits
     * @return mixed
     */
    protected function getTotalSumForGtn13CheckDigit($digits)
    {
        $evenSum = ($digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11]);
        $oddSum = ($digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10]);
        return (($evenSum * 3) + $oddSum);
    }

    /**
     * @param $digits
     * @return mixed
     */
    protected function getTotalSumForGtn14CheckDigit($digits)
    {
        $evenSum = ($digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11]);
        $oddSum = ($digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10] + $digits[12]);
        return ($evenSum + ($oddSum * 3));
    }

    /**
     * @param $sum
     * @return float
     */
    protected function subtractSumFromNearestOrHigherTen($sum)
    {
        return ($this->getNearestTenFromSum($sum) - $sum);
    }

    /**
     * @param $digits
     * @param $length
     * @return string
     * @throws \Exception
     */
    protected function parseDigits($digits, $length)
    {
        if (!is_numeric($digits)) {
            throw new \Exception('Not a number.');
        }
        if (strlen($digits) != $length) {
            throw new \Exception('Number has an invalid amount of digits.');
        }

        return (string)$digits;
    }
}