<?php

use Hwl\Common\Operations;
use Hwl\Service\DeliveryService;
use Hwl\Service\GTINService;

class OperationTest extends PHPUnit_Framework_TestCase {

    public function testFindDeliveryDatesIsTrue()
    {
        $this->assertTrue(
            $this->getOperations()->calculateAvailableDeliveryDates(new \DateTime())
        );
    }

    public function testNextDayDeliveryDate()
    {
        $operation = $this->getOperations();
        $monday = \DateTime::createFromFormat('d-m-Y', '18-01-2016');

        $operation->calculateAvailableDeliveryDates($monday);
        $this->assertEquals('19-01-2016', $operation->getNextDayDelivery());
    }

    public function testEconomyDeliveryDate()
    {
        $operation = $this->getOperations();
        $wednesday = \DateTime::createFromFormat('d-m-Y', '20-01-2016');

        $operation->calculateAvailableDeliveryDates($wednesday);
        $this->assertEquals('25-01-2016', $operation->getEconomyDelivery());
    }

    public function testCalculateGTINCheckDigitIsTrue()
    {
        $operation = $this->getOperations();
        $this->assertTrue($operation->calculateGTIN('9638507'));
    }

    public function testCalculateGTINCheckDigitIsFalse()
    {
        $operation = $this->getOperations();
        $this->assertFalse($operation->calculateGTIN('963850'));
        $this->assertFalse($operation->calculateGTIN('96385022'));
    }

    public function testCalculateGTIN8CheckDigit()
    {
        $operation = $this->getOperations();
        $operation->calculateGTIN('9638507');
        $this->assertEquals('96385074', $operation->getGTIN8());
    }

    public function testCalculateGTIN12CheckDigit()
    {
        $operation = $this->getOperations();
        $operation->calculateGTIN('98765432109');
        $this->assertEquals('987654321098', $operation->getGTIN12());
    }

    public function testCalculateGTIN13CheckDigit()
    {
        $operation = $this->getOperations();
        $operation->calculateGTIN('590123412345');
        $this->assertEquals('5901234123457', $operation->getGTIN13());
    }

    public function testCalculateGTIN14CheckDigit()
    {
        $operation = $this->getOperations();
        $operation->calculateGTIN('1312345123456');
        $this->assertEquals('13123451234566', $operation->getGTIN14());
    }

    public function testErrorsAreLogged()
    {
        $deliveryService = new DeliveryService();
        $gtinService = new GTINService();

        $deliveryService->modifyWorkingDays(array());
        $operation = new Operations($deliveryService, $gtinService);

        $monday = \DateTime::createFromFormat('d-m-Y', '18-01-2016');
        $tuesday = \DateTime::createFromFormat('d-m-Y', '19-01-2016');

        $this->assertFalse($operation->calculateAvailableDeliveryDates($monday));
        $this->assertEquals('1', count($operation->getErrors()));
        $this->assertFalse($operation->calculateAvailableDeliveryDates($tuesday));
        $this->assertEquals('2', count($operation->getErrors()));
    }

    protected function getOperations()
    {
        return new Operations(
            new DeliveryService(),
            new GTINService()
        );
    }
}