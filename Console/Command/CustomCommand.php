<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Bluethinkinc\QueueLearning\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Magento\Sales\Api\Data\OrderInterface;
use Psr\Log\LoggerInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

/**
 * Class CustomCommand
 */
class CustomCommand extends Command
{

  /**
  * @var OrderInterface
  */
  private $order;

  /**
  * @var LoggerInterface
  */
  private $logger;

  /**
  * @var CollectionFactory
  */
  private $orderCollectionFactory;

  public function __construct(
    OrderInterface $order,
    LoggerInterface $logger,
    CollectionFactory $orderCollectionFactory
  ) {
    $this->order = $order;
    $this->logger = $logger;
    $this->orderCollectionFactory = $orderCollectionFactory;
    parent::__construct();
  }

  protected function configure()
  {
        $this->setName('order')->setDescription('Prints order related data.');
  }
    
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $helper = $this->getHelper('question');
    $question = new ChoiceQuestion(
        'Please Select one of the option',
        [
          'Update order status', 
          'Get list of order that we have shipped'
        ],
      );

    $options = $helper->ask($input, $output, $question);
    if ($options == "Update order status") {
      $inputValue = $this->askForInput($input, $output, 'Please enter order increment id and order status: ');
      if (!empty($inputValue)) {
        $orderData = explode(",", $inputValue);
        $order = array_map('trim', $orderData);
        $this->getOrderByIncrementId($order,$output);
      } else {
        $output->writeln("Please enter increment id and order status");
      }
    } else {
      $shippedOrders = $this->getShippedOrders();
      print_r($shippedOrders);
    }

  }

  protected function askForInput(InputInterface $input, OutputInterface $output, $question, callable $validator = null)
  {
    $helper = $this->getHelper('question');
    $question = new Question($question);
    if ($validator !== null) {
      $question->setValidator($validator);
    }
    return $helper->ask($input, $output, $question);
  }

  public function getOrderByIncrementId($orderIncrementId, $output)
  {
    $order = $this->order->loadByIncrementId($orderIncrementId['0']);
    if (count($order->getData()) > 0) {
      try {
        foreach ($order->getData() as $key => $data) {
          $order->setStatus($orderIncrementId['1'])->save();
        }
      } catch (\Exception $e) { 
          $this->logger->info($e->getMessages()); 
      }
      $output->writeln("Order status has been updated");
    } else {
      $output->writeln("Please enter valid increment order id ");
    }
  }

  public function getShippedOrders()
    {
      $orderCollection = $this->orderCollectionFactory->create();
      $orderCollection->addFieldToFilter('status', 'complete');
      $orders = $orderCollection->load();
      $shippedOrders = [];
      foreach ($orders as $order) {
          $shippedOrders[] = [
              'increment_id' => $order->getIncrementId(),
              'customer_name' => $order->getCustomerName()
          ];
      }

      return $shippedOrders;
    }

}
