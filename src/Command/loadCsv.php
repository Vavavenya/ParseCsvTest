<?php
namespace App\Command;

use League\Csv\Reader;
use App\Entity\ProductData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class loadCsv extends Command 
{
    private $entityManager;

    public function __construct(string $testmode="normal",string $path ="",EntityManagerInterface $em)  //construct with arguments
    {
        parent::__construct();
        $this->path = $path;
        $this->testmode = $testmode;
        $this->entityManager = $em;
    }

    protected function configure() //regist command and arguments
    {
         $this
        ->setName('app:loadCsv')
        ->addArgument('path',InputArgument::REQUIRED, 'path')
        ->addArgument('testmode',InputArgument::OPTIONAL, 'testmode');
    }

    private function checkData($cost,$stock) :bool    //check import rules
     {
      if ($cost<5 && $stock<10 || $cost>1000)
        return true;
      else
        return false;
     }

    private function drawResultTable($total,$skiped,$output)   //draw table with report
     {
     	$table = new Table($output);
     	$table
     	->setHeaders(array('Total records', 'Skipped', 'Successful'))
     	->setRows(array(array($total, $skiped,$total-$skiped)));
     	$table->render();
     }

     private function drawIncorrectRecords($wrongRecords,$output) //create report with wrond records
     {
     	$table = new Table($output);
     	$table->setHeaders(array('Product Code', 'Product Name', 'Product Description','Stock','Cost in GBP','Discontinued'));
      $table->setRows($wrongRecords);
     	$table->render();
     }

     private function parseCsvFile($path)   //get data from csv file
     {
     	$reader = Reader::createFromPath($path);
      $reader->setHeaderOffset(0);
      $records = $reader->getRecords();
      return $records;
     }

     private function createProduct($record)  // create fill and return object
     {
       $product = new ProductData();
       $nowdate = new \DateTime("now");

        $product
          ->setStrProductName($record["Product Name"])
          ->setStrProductDesc($record["Product Description"])
          ->setStrProductCode($record["Product Code"])
          ->setStock($record["Stock"])
          ->setCostInGBP($record["Cost in GBP"])
          ->setDtmDescontinued($record["Discontinued"] == "yes"?$nowdate:null)
          ->setStmTimestamp($nowdate);

         return $product;
     }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$io = new SymfonyStyle($input,$output);
      $io->title('       START       ');

      $records = $this->parseCsvFile($input->getArgument('path'));

      $amountrecord = iterator_count($records);    //get amount total records
      $amountskiped = 0;

      $io->progressStart($amountrecord);    //start progress bar
      $errorRecords = array();   //array for incorrect records

      foreach ($records as $record){
        $io->progressAdvance();  //refresh progress bar
        if ($this->checkData($record["Cost in GBP"],$record["Stock"]))
         {
           $errorRecords[$amountskiped] = $record;
           $amountskiped++;  //count rerocrds which skip
           continue;
         }
        $readyProduct = $this->createProduct($record);
        $this->entityManager->persist($readyProduct); //persist product:object

        if ($input->getArgument('testmode') != "test")
        $this->entityManager->flush();  //insert in database
      }

      $io->progressFinish(); //end progress bar
      $io->warning("Incorrect records : $amountskiped");
      $this->drawIncorrectRecords($errorRecords,$output);
      $io->success('Report');
      $this->drawResultTable($amountrecord,$amountskiped,$output);
     }
}