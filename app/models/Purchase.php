<?php

class Purchase
{
    use Model;

    protected $table = 'purchase';

    protected $allowedColumns = [
       'buyer_id',
       'harvest_id',
       'amount',
       'rating'
    ];
}