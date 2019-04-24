<?php


namespace App\Model\Repositories;

use App\Exceptions\UserException;
use App\UserDetails;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Storage;
/**
 * Class UserRepository implements operations, related with User
 */
class UserRepository extends BaseRepository
{
    /**
     * @var SocialNetwork|null
     */
    protected $socialNetwork = null;

    public function __construct()
    {
      //  $this->socialNetwork = $socialNetwork;
    }

    
	
    /**
     * Get list users in system.
     *
     * @param string  $type   - the query type. Valid values: "count" (for COUNT query)
     *                          and "rows" (for standard SELECT query).
     * @param integer $offset - data set offset.
     * @param integer $limit  - the size of record set.
     * @param array   $params - filters for searching.
     *
     * @return array|User[]
     * @access public
     */
    public function getListUsers($type = BaseRepository::QUERY_TYPE_ROWS, $offset = 0, $limit = 10, $params = [])
    {
		//\DB::enableQueryLog();
		$query = DB::table("users_details")->select('users_details.*','countries.name As CountryName')->leftjoin("countries","countries.countryID" ,"=","users_details.country");	
     //   $query = DB::table('users_details');	

        $query->where('deleted_at', '=', Null);
            

	    if (!empty($params['keyword'])) {
            $query->where(function ($q) use ($params) {
                $q->where('first_name', 'LIKE', '%' . $params['keyword'] . '%')
				  ->orWhere('last_name', 'LIKE', '%' . $params['keyword'] . '%')
                  ->orWhere('countries.name', 'LIKE', '%' . $params['keyword'] . '%')
				  ->orWhere('debut', 'LIKE', '%' . $params['keyword'] . '%');				  
            });
        }

        if ($type == BaseRepository::QUERY_TYPE_COUNT) {
            return $query->count();
        }
		
        if (!isset($params['orders'])) {
            $params['orders'] = [
                'id' => 'desc',
            ];
        }
        foreach ($params['orders'] as $key => $dir) {
            $query->orderBy($key, $dir);
        }
		 
		//dd(\DB::getQueryLog());
        return $query
            ->select(['*'])
           // ->where('deleted_at','!=',Null)
            ->skip($offset)
            ->limit($limit)
            ->get();
    }
   

}
