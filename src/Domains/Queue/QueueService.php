<?php

namespace kosuha606\VirtualAdmin\Domains\Queue;

use kosuha606\VirtualModel\VirtualModelManager;

class QueueService
{
    /**
     * @param QueueJobInterface $job
     * @param array $args
     * @throws \Exception
     */
    public function pushJob($jobClass, $args = [], $jobId = null, $startAfter = null)
    {
        try {
            $job = new $jobClass();
            if (!$job instanceof QueueJobInterface) {
                throw new \LogicException('Job of queue should realize QueueJobInterface');
            }
        } catch (\LogicException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new \LogicException('Some error in job queue push: '.$exception->getMessage());
        }

        if (!$startAfter) {
            $startAfter = date('Y-m-d H:i:s');
        }

        $queue = QueueVm::create([
            'job_class' => $jobClass,
            'job_id' => $jobId,
            'arguments' => json_encode($args, JSON_UNESCAPED_UNICODE),
            'created_at' => date('Y-m-d H:i:s'),
            'start_after' => $startAfter,
        ]);
        $queue->save();
    }

    /**
     * @param QueueVm $queueVm
     * @return mixed
     */
    public function runJob(QueueVm $queueVm)
    {
        $jobClass = $queueVm->job_class;

        try {
            $args = json_decode($queueVm->arguments, true);
        } catch (\Exception $exception) {
            $args = [];
        }

        /** @var QueueJobInterface $job */
        $job = new $jobClass();

        return $job->run($args);
    }

    /**
     * @param null $jobClass
     * @throws \Exception
     */
    public function popAndRunJob($jobClass = null)
    {
        $where = [['all']];

        if ($jobClass) {
            $where = [['=', 'job_class', $jobClass]];
        }

        /** @var QueueVm $queue */
        $queue = VirtualModelManager::getEntity(QueueVm::class)::one([
            'where' => $where,
            'orderBy' => ['created_at' => SORT_ASC],
        ]);

        $result = null;

        if ($queue->id) {
            $result = $this->runJob($queue);
            $queue->delete();
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function popAndRunAllJobs($jobClass = null)
    {
        $startAfter = date('Y-m-d H:i:s');
        $where = [
            ['<=', 'start_after', $startAfter]
        ];
        
        if ($jobClass) {
            $where[] = ['=', 'job_class', $jobClass];
        }
    
        /** @var QueueVm[] $queues */
        $queues = VirtualModelManager::getEntity(QueueVm::class)::many([
            'where' => $where,
            'orderBy' => ['created_at' => SORT_ASC],
        ]);

        foreach ($queues as $queue) {
            $this->runJob($queue);
            $queue->delete();
        }

        return count($queues);
    }
}
