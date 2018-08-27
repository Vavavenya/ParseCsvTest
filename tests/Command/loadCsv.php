<?php

namespace App\Tests\Command;

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