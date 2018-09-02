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

    public function __construct(string $testmode="normal", string $path ="",EntityManagerInterface $em = null)  //construct with arguments
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
      ->addArgument('path', InputArgument::REQUIRED, 'path')
      ->addArgument('testmode', InputArgument::OPTIONAL, 'testmode');
    }

    public function checkData(?string $cost, ?string $stock) :bool    //check import rules
    {
      if ($cost<5 && $stock<10 || $cost>1000) {
        return true;
      } else {
        return false;
      }
    }

    private function drawResultTable(int $total, int $skiped,OutputInterface $output)   //draw table with report
    {
      $table = new Table($output);
      $table
      ->setHeaders(array('Total records', 'Skipped', 'Successful'))
      ->setRows(array(array($total, $skiped, $total-$skiped)));
      $table->render();
    }

    private function drawIncorrectRecords(array $wrongRecords, OutputInterface $output) //create report with wrond records
     {
      $table = new Table($output);
      $table->setHeaders(array('Product Code', 'Product Name', 'Product Description','Stock','Cost in GBP','Discontinued'));
      $table->setRows($wrongRecords);
      $table->render();
    }

    public function parseCsvFile(string $path)   //get data from csv file
     {
      $reader = Reader::createFromPath($path);
      $reader->setHeaderOffset(0);
      $records = $reader->getRecords();
      return $records;
    }

    private function createProduct(array $record) :ProductData  // create fill and return object
     {
       $product = new ProductData();
       $nowdate = new \DateTime("now");

       $product
       ->setProductName($record["Product Name"])
       ->setProductDescription($record["Product Description"])
       ->setProductCode($record["Product Code"])
       ->setDateAdded($nowdate)
       ->setStock($record["Stock"])
       ->setCostGBP($record["Cost in GBP"])
       ->setDateDiscontinued($record["Discontinued"] == "yes"?$nowdate:null);

       return $product;
     }

    protected function execute(InputInterface $input, OutputInterface $output)
     {
       $io = new SymfonyStyle($input, $output);
       $io->title('       START       ');

       $records = $this->parseCsvFile($input->getArgument('path'));

       $amountrecord = iterator_count($records);
       $amountskiped = 0;

       $io->progressStart($amountrecord);
       $errorRecords = array();

       foreach ($records as $record) {
        $io->progressAdvance();
         if ($this->checkData($record["Cost in GBP"], $record["Stock"])) {
          $errorRecords[$amountskiped] = $record;
          $amountskiped++;
          continue;
         }
        $readyProduct = $this->createProduct($record);
        $this->entityManager->persist($readyProduct);

        if ($input->getArgument('testmode') != "test") {
         $this->entityManager->flush();
        }
     }

      $io->progressFinish();
      $io->warning("Incorrect records : $amountskiped");
      $this->drawIncorrectRecords($errorRecords, $output);
      $io->success('Report');
      $this->drawResultTable($amountrecord, $amountskiped, $output);
    }
  }