<?php

class Purchase
{
    use Model;

    protected $table = 'purchase';

    protected $allowedColumns = [
       'buyer-id',
       'harvest-id',
       'amount',
    ];
}