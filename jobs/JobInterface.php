<?php

namespace jobs;

interface JobInterface
{
    /**
     * Executes the job.
     *
     * @param \yii\queue\Queue $queue The queue handling the job.
     */
    public function execute($queue);
}
