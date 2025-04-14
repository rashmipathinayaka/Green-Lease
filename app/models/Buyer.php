<?php

class Bid
{
    use Model;

    protected $table = 'bid';

    protected $allowedColumns = [
       'bid-id',
       'buyer-id',
       'harvest-id',
       'project-id',
       'amount(kg)',
       'unit-price',
    ];
}