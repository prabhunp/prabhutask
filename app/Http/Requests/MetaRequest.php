<?php

namespace App\Http\Requests;

use App\Http\Requests\Interfaces\IMetaRequest;
use App\Model\Repositories\BaseRepository;
use Illuminate\Http\Request;

/**
 * Class MetaRequest
 * This class is used for meta requests (having search, filter with 'offset', 'limit' parameters)
 *
 * @method array getEvents($gameID, $type, $offset, $limit)
 * @method array getChatMessages($poolID, $type, $offset, $limit)
 * @method array getNewsList($type, $offset, $limit)
 * @method array getNotifications($type, $offset, $limit)
 * @method array getAvatars($userID, $type, $offset, $limit)
 * @method array listBrackets($userID, $type, $offset, $limit, $params)
 * @method array poolBrackets($poolID, $type, $offset, $limit, $params)
 * @method array search($user, $type, $offset, $limit, $params)
 * @package App\Http\Requests
 */
class MetaRequest implements IMetaRequest
{
    /**
     * Namespace of all repository classes.
     */
    protected static $repositoryNamespace = 'App\Model\Repositories';

    /**
     * Repository instance.
     *
     * @var BaseRepository
     */
    public $repository;

    /**
     * Route name for generation next url.
     *
     * @var string
     */
    protected $routeName;

    /**
     * The total number of items is calculated by the repository.
     *
     * @var integer
     */
    protected $count;

    /**
     * The array of items is returned from the repository.
     *
     * @var array
     */
    protected $rows;
    /**
     * The request query parameters.
     *
     * @var array
     */
    protected $params;

    /**
     * Use for remembering indexes of meta keys in list arguments
     *
     * @var array
     */
    protected $rememberMetaIndexes = [];

    /**
     * Create a new instance.
     *
     * @param string $repositoryName - name of the repository with process request
     * @param string $routeName - name of route for generation next url
     * @param Request $request
     *
     * @access public
     */
    public function __construct($repositoryName, $routeName, Request $request)
    {
        $this->routeName = $routeName;
        $this->initRepository($repositoryName);
        $this->initParams($request);
    }

    /**
     * Init parameters for request.
     *
     * @param Request $request
     * @access protected
     */
    protected function initParams(Request $request)
    {
        $this->params = [
            self::PARAM_OFFSET => $request->query(self::PARAM_OFFSET, 0),
            self::PARAM_LIMIT => $request->query(self::PARAM_LIMIT) ?: self::DEFAULT_LIMIT
        ];
    }

    /**
     * Set query params.
     *
     * @param array $params
     * @return $this
     * @access public
     */
    public function setQueryParams($params)
    {
        $this->params = array_merge([
            self::PARAM_OFFSET => $this->params[self::PARAM_OFFSET],
            self::PARAM_LIMIT => $this->params[self::PARAM_LIMIT]
        ], $params);

        return $this;
    }

    /**
     * Init repository instance.
     *
     * @param string $className
     * @access protected
     */
    protected function initRepository($className)
    {
        $this->repository = app($className);
    }

    /**
     * Calls particular repository method.
     *
     * @param string $method - the repository method.
     * @param array $args - the repository method parameters.
     * @return $this
     * @access public
     */
    public function __call($method, $args)
    {
        $this->putMetaValue(self::META_OFFSET, (int)$this->params[self::PARAM_OFFSET], $args);
        $this->putMetaValue(self::META_LIMIT, (int)$this->params[self::PARAM_LIMIT], $args);
        $this->putMetaValue(self::META_QUERY_TYPE, self::QUERY_TYPE_COUNT, $args);
        $this->count = call_user_func_array(array($this->repository, $method), $args);

        $this->putMetaValue(self::META_QUERY_TYPE, self::QUERY_TYPE_ROWS, $args);
        $this->rows = call_user_func_array(array($this->repository, $method), $args);

        return $this;
    }

    /**
     * Find meta key and put value to given array
     *
     * @param string $key - meta key
     * @param mixed $value
     * @param array $args
     * @return integer|boolean - index of meta key in array. Return false if not found the meta key.
     * @access protected
     */
    protected function putMetaValue($key, $value, &$args)
    {
        $idx = $this->getRememberedIndex($key);
        if ($idx === false) {
            $idx = array_search($key, $args, true);
        }

        if (isset($args[$idx])) {
            // put value at found index
            $args[$idx] = $value;

            // add meta key to remember index array
            $this->rememberMetaIndexes[$key] = $idx;

            return $idx;
        } else {
            // remove meta key from remembered index array
            unset($this->rememberMetaIndexes[$key]);

            return false;
        }
    }

    /**
     * Get remembered index of a meta key
     *
     * @param string $key - meta key
     * @return integer|boolean - index of meta key or false if not found meta key in remembered index array
     * @access protected
     */
    protected function getRememberedIndex($key)
    {
        if (isset($this->rememberMetaIndexes[$key]) && is_int($this->rememberMetaIndexes[$key])) {
            return $this->rememberMetaIndexes[$key];
        } else {
            return false;
        }
    }

    /**
     * Generate next url.
     *
     * @return string|null
     * @access protected
     */
    protected function getNextUrl()
    {
        $params = $this->params;
        $params[self::PARAM_OFFSET] = (int)$params[self::PARAM_OFFSET] + (int)$params[self::PARAM_LIMIT];
        return $params[self::PARAM_OFFSET] < (int)$this->count ? route($this->routeName, $params) : null;
    }

    /**
     * Calculate next offset.
     *
     * @return int|null
     * @access protected
     */
    protected function getNextOffset()
    {
        $nextOffset = (int)$this->params[self::PARAM_OFFSET] + (int)$this->params[self::PARAM_LIMIT];
        return $nextOffset < (int)$this->count ? $nextOffset : null;
    }

    /**
     *
     * Get meta response in array.
     *
     * @return array
     * @access public
     */
    public function getResponse()
    {
        return [
            'meta' => [
                'total' => (int)$this->count,
                'offset' => (int)$this->params[self::PARAM_OFFSET],
                'limit' => (int)$this->params[self::PARAM_LIMIT],
                'next' => $this->getNextOffset()
            ],
            'records' => (array)$this->rows
        ];
    }

    /**
     * Getter of rows
     *
     * @return array
     * @access public
     */
    public function getRows()
    {
        return (array)$this->rows;
    }

    /**
     * Setter of rows
     *
     * @param array $rows
     * @return $this
     * @access public
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}
