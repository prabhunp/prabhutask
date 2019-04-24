<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

/**
 * Class DataTableRequest
 * This class is used for data table requests.
 *
 * @method void getListTournaments($type, $offset, $limit, $params)
 * @method void getListRegions($tournamentID, $type, $offset, $limit, $params)
 * @method void getListUsers($type, $offset, $limit, $params)
 * @method void getTopUsers($poolID, $keyword, $type, $offset, $limit)
 * @method void search($user, $type, $offset, $limit, $params)
 * @package App\Http\Requests
 */
class DataTableRequest extends MetaRequest
{
    /**
     * Default limit.
     *
     * @var integer
     */
    const DEFAULT_LIMIT = 10;

    /**
     * Orders parameter.
     *
     * @var string
     */
    const PARAM_ORDERS = 'orders';

    /**
     * Keyword parameter.
     *
     * @var string
     */
    const PARAM_KEYWORD = 'keyword';

    /**
     * Draw param from table data request.
     *
     * @var integer
     */
    protected $draw;

    /**
     * Keyword param from table data request.
     *
     * @var integer
     */
    protected $keyword;

    /**
     * Name of offset param in request.
     *
     * @var string
     */
    private $offsetParamName = 'start';

    /**
     * Name of limit param in request.
     *
     * @var string
     */
    private $limitParamName = 'length';

    /**
     * Order columns are used for sorting.
     *
     * @var array
     */
    private $orderKeys = [];

    /**
     * Current order columns.
     *
     * @var array
     */
    private $orders = [];

    /**
     * Create a new instance.
     *
     * @param string $repositoryName - name of the repository with process request
     * @param Request $request
     * @param array $orderKeys - order columns
     *
     * @access public
     */
    public function __construct($repositoryName, Request $request, $orderKeys = [])
    {
        $this->draw   = $request->query('draw');
        $this->keyword   = $request->query('search') ? $request->query('search')['value'] : '';
        $this->orderKeys = $orderKeys;
        return parent::__construct($repositoryName, '', $request);
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
            self::PARAM_OFFSET => $request->query($this->offsetParamName, 0),
            self::PARAM_LIMIT => $request->query($this->limitParamName) ?: self::DEFAULT_LIMIT,
        ];
        if ($this->orderKeys) {
            $this->initOrderParams($request);
            $this->params[self::PARAM_ORDERS] = $this->getOrderParams();
            $this->params[self::PARAM_KEYWORD] = $this->keyword;
        }
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

        if ($this->orderKeys) {
            $this->params[self::PARAM_ORDERS] = $this->getOrderParams();
            $this->params[self::PARAM_KEYWORD] = $this->keyword;
        }

        return $this;
    }

    /**
     * Init parameters for ordering.
     *
     * @param Request $request
     * @return array
     * @access protected
     */
    protected function initOrderParams(Request $request)
    {
        $columns = $request->query('columns');
        $orders  = $request->query('order');
        $this->orders = [];
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $name = $columns[$order['column']]['name'];
                if (in_array($name, $this->orderKeys)) {
                    $this->orders[$name] = $order['dir'];
                }
            }
        }
    }

    /**
     * Get parameters for ordering.
     *
     * @return array
     * @access public
     */
    public function getOrderParams()
    {
        return $this->orders;
    }

    /**
     * Get keyword for searching.
     *
     * @return string
     * @access public
     */
    public function getKeyword()
    {
        return $this->keyword;
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
            'draw' => $this->draw,
            'recordsTotal' => (int) $this->count,
            'recordsFiltered' => (int) $this->count,
            'data' => $this->rows,
        ];
    }
}
