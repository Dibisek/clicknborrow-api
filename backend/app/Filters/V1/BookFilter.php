<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class BookFilter extends ApiFilter{
    protected $safeParms = [
        'title' => ['eq', 'like'],
        'author' => ['eq'],
        'publicationDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'pageCount' => ['eq', 'gt', 'lt', 'gte', 'lte'],
    ];

    protected $columnMap = [
        'author' => 'author_id',
        'category' => 'categories.id',
        'publicationDate' => 'publication_date',
        'pageCount' => 'page_count',
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