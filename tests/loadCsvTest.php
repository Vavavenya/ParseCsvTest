<?php
namespace App\Tests;

use App\Command\loadCsv;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class loadCsvTest extends TestCase
{
    public function testCheckData()  //test control method for data
    {

        $CsvClass = new loadCsv("normal","");
        $result = $CsvClass->checkData("50","11");
        $this->assertEquals(false, $result);
    }

   public function testParseCsvFile()  //test method for get data from csv file
   {
   	$example = array(
      "Product Name"=> "TV",
   		"Stock"  => "10",
      "Cost in GBP" => "399.99");

      $CsvClass = new loadCsv("normal","");

      $file = __DIR__ . '\teststock.csv';
      var_dump($file);
      $results = $CsvClass->parseCsvFile($file);
      foreach ($results as $result) {   // it's bad solution
      	$this->assertEquals($example, $result);
      }
   }
}