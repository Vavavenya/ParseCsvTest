// tests/Util/CalculatorTest.php
namespace App\Tests\Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
<?php

namespace App\Tests\loadCsv;

use App\Command\loadCsv;
use PHPUnit\Framework\TestCase;

class loadCsvTest extends TestCase
{
    public function testCheckData()
    {
        $CsvClass = new loadCsv();
        $result = $CsvClass->checkData(100, 100);

        $this->assertEquals(true, $result);
    }
}