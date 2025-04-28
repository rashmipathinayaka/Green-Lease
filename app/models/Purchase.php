<?php

class Purchase
{
    use Model;

    protected $table = 'purchase';

    protected $allowedColumns = [
       'bid_id',
       'amount',
       'rating',
       'feedback'
    ];
}