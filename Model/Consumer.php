<?php

namespace Bluethinkinc\QueueLearning\Model;

use Bluethinkinc\QueueLearning\Model\StudentFactory;


class Consumer
{

    public function __construct(
        StudentFactory $studentFactory
    ) {
        $this->studentFactory = $studentFactory;
    }

    /**
     *
     * @api
     * @param string $stdId
     * @return bool
     */
	public function process($stdId)
	{
        try {
           if(!empty($stdId)) {
            $model = $this->studentFactory->create()->load($stdId);
            $model->delete();
           }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}