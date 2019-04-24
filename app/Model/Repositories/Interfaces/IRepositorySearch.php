<?php

namespace App\Model\Repositories\Interfaces;

/**
 * This interface is used for repositories that having search/filter items
 */
interface IRepositorySearch
{
    /**
     * search items by given id
     */
    const SEARCH_TYPE_ACCEPT = 1;

    /**
     * search items except given id
     */
    const SEARCH_TYPE_EXCEPT = 2;

    /**
     * query type count
     */
    const QUERY_TYPE_COUNT = 'count';

    /**
     * query type rows
     */
    const QUERY_TYPE_ROWS = 'rows';
}
