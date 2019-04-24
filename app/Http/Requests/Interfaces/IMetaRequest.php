<?php

namespace App\Http\Requests\Interfaces;

use App\Model\Repositories\Interfaces\IRepositorySearch;
use App\Model\Repositories\Interfaces\IRequestParams;

/**
 * This interface is used for providing param names in request
 */
interface IMetaRequest extends IRepositorySearch, IRequestParams
{
    /**
     * Default limit.
     *
     * @var integer
     */
    const DEFAULT_LIMIT = 100;

    /**
     * Offset parameter.
     *
     * @var string
     */
    const PARAM_OFFSET = 'offset';

    /**
     * Limit parameter.
     *
     * @var string
     */
    const PARAM_LIMIT = 'limit';

    /**
     * These constants are meta keys, indicate should be replaced by a meta value before call to repository methods.
     */
    const META_OFFSET = ':offset';
    const META_LIMIT = ':limit';
    const META_QUERY_TYPE = ':queryType';
}
