<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Bluethinkinc\QueueLearning\Controller\Adminhtml\Student;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bluethinkinc\QueueLearning\Model\ResourceModel\Student\CollectionFactory;
use Magento\Framework\MessageQueue\PublisherInterface ;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    

    const TOPIC_NAME = 'salesforce.queue.order';

	const SIZE = 5000;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

     /**
     * @var \Magento\Framework\MessageQueue\PublisherInterface
     */
    private $publisher;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Framework\MessageQueue\PublisherInterface $publisher
     */
    public function __construct(
        Context $context,
        Filter $filter, 
        CollectionFactory $collectionFactory,
        PublisherInterface $publisher
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->publisher = $publisher;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionData = $collection->getData('student_id');
        $collectionSize = $collection->getSize();
        foreach ($collectionData as $block) {
            
            $this->publisher->publish(self::TOPIC_NAME, $block['student_id']);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been send to queue.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
