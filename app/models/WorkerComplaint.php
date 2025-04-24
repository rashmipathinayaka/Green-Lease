<?php
class WorkerComplaint
{
    use Model;
    protected $table = 'worker_complaint';
    protected $allowedColumns = [
       'worker_id',
       'complaint_type',
       'description',
       'attachment'
    ];
}