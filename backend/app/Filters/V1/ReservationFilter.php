<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class ReservationFilter extends ApiFilter{
    protected $safeParms = [
        'user' => ['eq', 'like'],
        'book' => ['eq'],
        'startDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'endDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'status' => ['eq'],
    ];

    protected $columnMap = [
        'user' => 'user_id',
        'book' => 'book_id',
        'startDate' => 'start_date',
        'endDate' => 'end_date',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'like' => 'like',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
    ];
}