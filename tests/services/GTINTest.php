<?php

use Hwl\Service\GTINService;

class GTINTest extends PHPUnit_Framework_TestCase {

    public function testGTIN8CheckDigit()
    {
        $gtinService = new GTINService();
        $this->assertEquals('96385074', $gtinService->gtn8CheckDigit('9638507'));
        $this->assertEquals('95050003', $gtinService->gtn8CheckDigit('9505000'));
        $this->assertEquals('50184385', $gtinService->gtn8CheckDigit('5018438'));
    }

    public function testGTIN12CheckDigit()
    {
        $gtinService = new GTINService();
        $this->assertEquals('512345678900', $gtinService->gtn12CheckDigit('51234567890'));
        $this->assertEquals('987654321098', $gtinService->gtn12CheckDigit('98765432109'));
        $this->assertEquals('614141000036', $gtinService->gtn12CheckDigit('61414100003'));
    }

    public function testGTIN13CheckDigit()
    {
        $gtinService = new GTINService();
        $this->assertEquals('6291041500213', $gtinService->gtn13CheckDigit('629104150021'));
        $this->assertEquals('5901234123457', $gtinService->gtn13CheckDigit('590123412345'));
        $this->assertEquals('8032089000017', $gtinService->gtn13CheckDigit('803208900001'));
    }

    public function testGTIN14CheckDigit()
    {
        $gtinService = new GTINService();
        $this->assertEquals('00012345600012', $gtinService->gtn14CheckDigit('0001234560001'));
        $this->assertEquals('08032089005661', $gtinService->gtn14CheckDigit('0803208900566'));
        $this->assertEquals('13123451234566', $gtinService->gtn14CheckDigit('1312345123456'));
    }

    public function testGTIN8DigitInputType()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn8CheckDigit('test');
        } catch (\Exception $expect) {
            $this->assertEquals('Not a number.', $expect->getMessage());
        }
    }

    public function testGTIN8DigitInputLength()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn8CheckDigit('12345678');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
        try {
            $gtinService->gtn8CheckDigit('12');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
    }

    public function testGTIN12DigitInputType()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn12CheckDigit('test');
        } catch (\Exception $expect) {
            $this->assertEquals('Not a number.', $expect->getMessage());
        }
    }

    public function testGTIN12DigitInputLength()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn12CheckDigit('123456789012');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
        try {
            $gtinService->gtn12CheckDigit('345');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
    }

    public function testGTIN13DigitInputType()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn13CheckDigit('test123');
        } catch (\Exception $expect) {
            $this->assertEquals('Not a number.', $expect->getMessage());
        }
    }

    public function testGTIN13DigitInputLength()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn13CheckDigit('1234567890123');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
        try {
            $gtinService->gtn13CheckDigit('34545');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
    }

    public function testGTIN14DigitInputType()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn14CheckDigit('invalid number');
        } catch (\Exception $expect) {
            $this->assertEquals('Not a number.', $expect->getMessage());
        }
    }

    public function testGTIN14DigitInputLength()
    {
        $gtinService = new GTINService();
        try {
            $gtinService->gtn14CheckDigit('12345678901233');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
        try {
            $gtinService->gtn14CheckDigit('1');
        } catch (\Exception $expect) {
            $this->assertEquals('Number has an invalid amount of digits.', $expect->getMessage());
        }
    }

    public function testNearestOrHigherTenFromSum()
    {
        $gtinService = new GTINService();
        $this->assertEquals(10, $gtinService->getNearestTenFromSum(1));
        $this->assertEquals(60, $gtinService->getNearestTenFromSum(53));
        $this->assertEquals(230, $gtinService->getNearestTenFromSum(228));
    }
}