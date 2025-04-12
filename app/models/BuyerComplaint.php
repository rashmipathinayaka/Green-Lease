<?php
class BuyerComplaint
{
    use Model;
    protected $table = 'buyer_complaint';
    protected $allowedColumns = [
       'buyer_id',
       'complaint_type',
       'description',
       'attachment'
    ];
}