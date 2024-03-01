<?php

namespace Bluethinkinc\QueueLearning\Cron;

use Bluethinkinc\QueueLearning\Model\ResourceModel\Student\CollectionFactory;
use Bluethinkinc\QueueLearning\Model\StudentFactory;

class ConsoleCommandModel
{
    /**
    * @var CollectionFactory
    */
    private $collectionFactory;

    /**
    * @var StudentFactory
    */
    private $studentFactory;

    public function __construct ( 

        CollectionFactory $collectionFactory,
        StudentFactory $studentFactory
        ) {

        $this->collectionFactory = $collectionFactory;
        $this->studentFactory = $studentFactory;
    }

    public function execute()
    {
        $model = $this->studentFactory->create();
        $collection = $this->collectionFactory->create()->addFieldToFilter('status', 'new');
        try {
            foreach ($collection->getData() as $key => $data) {
                $this->updateStatus($data['student_id']);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateStatus($studentId) {
        $model = $this->studentFactory->create();
        $studentData = $model->load($studentId);
        $data = $studentData->getData();
        foreach ($data as $student) {
            $model->setStatus('pending')->save();
        }
    }
}
