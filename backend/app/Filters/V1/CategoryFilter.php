<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CategoryFilter extends ApiFilter{
    protected $safeParms = [
        'category' => ['eq', 'like'],
    ];

    protected $columnMap = [
        'category' => 'category_name',
    ];

    protected $operatorMap = [
        'like' => 'like',
        'eq' => '=',
    ];
}