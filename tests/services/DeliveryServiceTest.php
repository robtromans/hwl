<?php

use Hwl\Service\DeliveryService;

class DeliveryServiceTest extends PHPUnit_Framework_TestCase {

    public function testDefaultDeliveryDays()
    {
        $this->assertEquals(
            array('monday', 'tuesday', 'wednesday', 'thursday', 'friday'),
            $this->getDeliveryService()->getWorkingDays()
        );
    }

    public function testConfigurableWorkingDays()
    {
        $deliveryService = $this->getDeliveryService();
        $this->addSaturdayToWorkingDays($deliveryService);
        $this->assertEquals(
            array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'),
            $deliveryService->getWorkingDays()
        );

        $deliveryService->modifyWorkingDays(array('tuesday', 'wednesday', 'thursday'));
        $this->assertEquals(array('tuesday', 'wednesday', 'thursday'), $deliveryService->getWorkingDays());
    }

    public function testNextDayDeliveryDate()
    {
        $deliveryService = $this->getDeliveryService();

        $monday = \DateTime::createFromFormat('d-m-Y', '18-01-2016');
        $tuesday = \DateTime::createFromFormat('d-m-Y', '19-01-2016');
        $wednesday = \DateTime::createFromFormat('d-m-Y', '20-01-2016');
        $thursday = \DateTime::createFromFormat('d-m-Y', '21-01-2016');
        $friday = \DateTime::createFromFormat('d-m-Y', '22-01-2016');
        $saturday = \DateTime::createFromFormat('d-m-Y', '23-01-2016');
        $sunday = \DateTime::createFromFormat('d-m-Y', '24-01-2016');

        $this->calculateNextDeliveryDate($deliveryService, $monday);
        $this->assertEquals('19-01-2016', $deliveryService->getNextDayDelivery());

        $this->calculateNextDeliveryDate($deliveryService, $tuesday);
        $this->assertEquals('20-01-2016', $deliveryService->getNextDayDelivery());

        $this->calculateNextDeliveryDate($deliveryService, $wednesday);
        $this->assertEquals('21-01-2016', $deliveryService->getNextDayDelivery());

        $this->calculateNextDeliveryDate($deliveryService, $thursday);
        $this->assertEquals('22-01-2016', $deliveryService->getNextDayDelivery());

        $this->calculateNextDeliveryDate($deliveryService, $friday);
        $this->assertEquals('25-01-2016', $deliveryService->getNextDayDelivery());

        $this->calculateNextDeliveryDate($deliveryService, $saturday);
        $this->assertEquals('25-01-2016', $deliveryService->getNextDayDelivery());

        $this->calculateNextDeliveryDate($deliveryService, $sunday);
        $this->assertEquals('25-01-2016', $deliveryService->getNextDayDelivery());
    }

    public function testSaturdayAsANextWorkingDay()
    {
        $deliveryService = $this->getDeliveryService();
        $this->addSaturdayToWorkingDays($deliveryService);
        $friday = \DateTime::createFromFormat('d-m-Y', '15-01-2016');
        $this->calculateNextDeliveryDate($deliveryService, $friday);
        $this->assertEquals('16-01-2016', $deliveryService->getNextDayDelivery());
    }

    public function testEconomyDeliveryDate()
    {
        $deliveryService = $this->getDeliveryService();

        $monday = \DateTime::createFromFormat('d-m-Y', '08-02-2016');
        $tuesday = \DateTime::createFromFormat('d-m-Y', '09-02-2016');
        $wednesday = \DateTime::createFromFormat('d-m-Y', '10-02-2016');
        $thursday = \DateTime::createFromFormat('d-m-Y', '11-02-2016');
        $friday = \DateTime::createFromFormat('d-m-Y', '12-02-2016');
        $saturday = \DateTime::createFromFormat('d-m-Y', '13-02-2016');
        $sunday = \DateTime::createFromFormat('d-m-Y', '14-02-2016');

        $this->calculateEconomyDeliveryDate($deliveryService, $monday);
        $this->assertEquals('11-02-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $tuesday);
        $this->assertEquals('12-02-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $wednesday);
        $this->assertEquals('15-02-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $thursday);
        $this->assertEquals('16-02-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $friday);
        $this->assertEquals('17-02-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $saturday);
        $this->assertEquals('17-02-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $sunday);
        $this->assertEquals('17-02-2016', $deliveryService->getEconomyDelivery());
    }

    public function testEconomyRangeCanBeChanged()
    {
        $deliveryService = $this->getDeliveryService();
        $deliveryService->economyRange = 4;

        $monday = \DateTime::createFromFormat('d-m-Y', '07-03-2016');
        $tuesday = \DateTime::createFromFormat('d-m-Y', '08-03-2016');
        $wednesday = \DateTime::createFromFormat('d-m-Y', '09-03-2016');
        $thursday = \DateTime::createFromFormat('d-m-Y', '10-03-2016');
        $friday = \DateTime::createFromFormat('d-m-Y', '11-03-2016');
        $saturday = \DateTime::createFromFormat('d-m-Y', '12-03-2016');
        $sunday = \DateTime::createFromFormat('d-m-Y', '13-03-2016');

        $this->calculateEconomyDeliveryDate($deliveryService, $monday);
        $this->assertEquals('11-03-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $tuesday);
        $this->assertEquals('14-03-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $wednesday);
        $this->assertEquals('15-03-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $thursday);
        $this->assertEquals('16-03-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $friday);
        $this->assertEquals('17-03-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $saturday);
        $this->assertEquals('17-03-2016', $deliveryService->getEconomyDelivery());

        $this->calculateEconomyDeliveryDate($deliveryService, $sunday);
        $this->assertEquals('17-03-2016', $deliveryService->getEconomyDelivery());
    }

    public function testEconomyDeliveryChangeWithSaturday()
    {
        $deliveryService = $this->getDeliveryService();
        $deliveryService->economyRange = 2;
        $this->addSaturdayToWorkingDays($deliveryService);

        $friday = \DateTime::createFromFormat('d-m-Y', '11-03-2016');
        $this->calculateEconomyDeliveryDate($deliveryService, $friday);
        $this->assertEquals('14-03-2016', $deliveryService->getEconomyDelivery());
    }

    public function testNoDeliveryDays()
    {
        $deliveryService = $this->getDeliveryService();
        $deliveryService->modifyWorkingDays(array());

        $monday = \DateTime::createFromFormat('d-m-Y', '18-01-2016');
        try {
            $this->calculateEconomyDeliveryDate($deliveryService, $monday);
        } catch (\Exception $expected) {
            $this->assertEquals('No days available.', $expected->getMessage());
        }
    }

    private function addSaturdayToWorkingDays($deliveryService)
    {
        $days = $deliveryService->getWorkingDays();
        array_push($days, 'saturday');
        return $deliveryService->modifyWorkingDays($days);
    }

    protected function getDeliveryService()
    {
        return new DeliveryService();
    }

    protected function calculateNextDeliveryDate($deliveryService, $day)
    {
        return $deliveryService->setNextDayDelivery(
            $deliveryService->calculateDeliveryDate($day, $deliveryService->getNextDayRange())
        );
    }

    protected function calculateEconomyDeliveryDate($deliveryService, $day)
    {
        return $deliveryService->setEconomyDelivery(
            $deliveryService->calculateDeliveryDate($day, $deliveryService->getEconomyRange())
        );
    }
}