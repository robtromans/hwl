<?php

namespace Hwl\Service;

interface GTINInterface {

    public function gtn8CheckDigit($digits);

    public function gtn12CheckDigit($digits);

    public function gtn13CheckDigit($digits);

    public function gtn14CheckDigit($digits);
}