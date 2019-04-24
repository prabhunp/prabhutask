<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DataTableRequest;
use App\Model\Repositories\UserRepository;
use App\UserDetails;
use App\Countries;
use DB;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserDetailsController extends Controller {
    //
    public function index() {
    	//$userdetails = UserDetails::order->paginate(10);
        return view('userdetails.index');
    }

    public function createUsers(){
    	$countriesRes	=	DB::table('countries')->get();
    	return view('userdetails.createuser',['countries'=>$countriesRes]);
    }

    public function storeUsers(Request $request) {
    	$requestInfo	=	$request->all();
    	//dd($request->toArray());
		$credentials = $request->only('first_name','last_name','country','debut');
        
        $rules = [
            'first_name' => 'required|string|max:255',
			'last_name' => 'required|string',
			'country' => 'required',
			'debut' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
			//$countriesRes = Countries::get();
			$countriesRes	=	DB::table('countries')->get();
         	return view('userdetails.createuser',['errors'=> $validator->messages(), 'countries'=>$countriesRes]);
        }
        $image_file = $request->file('profile_image');
        if($request->hasFile('profile_image') ) {
			$allowed =  array('jpg','png','jpeg');
			$fileformat = $image_file->getClientOriginalExtension();
			if(!in_array($fileformat,$allowed) ) {
				$countriesRes	=	DB::table('countries')->get();
				$validator->errors()->add('music_file', 'The profile image file must be a file of type: jpg,png,jpeg!');
         		return view('userdetails.createuser',['errors'=> $validator->messages(), 'countries'=>$countriesRes]);
			}		
			$filename = str_replace(' ', '_', $request->title).'_'.md5(uniqid()).'.'.$image_file->getClientOriginalExtension();			
			//$location = public_path('userimage');
				//$image_file->move($location,$filename);	
				$image = Input::file('profile_image');
				$file = $request->file('profile_image');
				$image_name = $file->getClientOriginalName();
				Storage::disk('public')->putFileAs('userimage',$image,$image_name);
			
			$image_file = $image_name;
		}
		if(empty($image_file)) {
			$image_file = '';
		}

  		$data['first_name']		=	$request->first_name;
		$data['last_name']		=	$request->last_name;				
		$data['birthday']		=	$request->birthday;
		$data['profile_image']	=	$image_file;
		$data['country']		=	$request->country;
		$data['height']			= 	$request->height;
		$data['weight']			=	$request->weight;		
		$data['team_name']			=	$request->team_name;
		$data['position']		=	$request->position;		
		$data['member']			=	$request->member;
		$data['college']		=	$request->college;
		$data['debut']			=	$request->debut;
		//dd($data);
		$user 	= 	UserDetails::userCreate($data);

        //UserDetails::create($request->all());
   
        return redirect()->route('userdetails')->with('success','UsersDetails created successfully.');
    } 


    public function editusersDetails(Request $request){
    	$requestInfo	=	$request->all();
		$userid 		=	$requestInfo['userid'];
    	$userdetails = UserDetails::find($userid);
    	$countriesRes	=	DB::table('countries')->get();
        return view('userdetails.edituser',['userdetails'=>$userdetails,'countries'=>$countriesRes]);
    }

    public function updateusersDetails(Request $request) {
    	// /dd($request->toArray());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'debut' => 'required',
        ]);
        $id = $request->userid;
  		$userdetails = UserDetails::find($id);
        $userdetails->update($request->all());

        $requestInfo = $request->all();
		$currentDateTime = Carbon::now();
		
		if($request->file_source_type == 'replace'){
			//$image_file = $request->file('profile_image');
			$image_file = $request->file('profile_image');
	        if($request->hasFile('profile_image') ) {
				$allowed =  array('jpg','png','jpeg');
				$fileformat = $image_file->getClientOriginalExtension();
				if(!in_array($fileformat,$allowed) ) {
					$countriesRes	=	DB::table('countries')->get();
					$validator->errors()->add('music_file', 'The profile image file must be a file of type: jpg,png,jpeg!');
	         		return view('userdetails.createuser',['errors'=> $validator->messages(), 'countries'=>$countriesRes]);
				}		
				$filename = str_replace(' ', '_', $request->title).'_'.md5(uniqid()).'.'.$image_file->getClientOriginalExtension();			
				//$location = public_path('userimage');
					//$image_file->move($location,$filename);	
					$image = Input::file('profile_image');
					$file = $request->file('profile_image');
					$image_name = $file->getClientOriginalName();
					Storage::disk('public')->putFileAs('userimage',$image,$image_name);
				
				$image_file = $image_name;
			}
		}elseif($request->file_source_type == 'keep'){
			$image_file = $request->file_name;
		}else{
			$image_file = '';
		}
		
		/*if(empty($image_file)) {
			$image_file = $request->file_name;
		}*/
		//dd($requestInfo);
		$userdetails = UserDetails::where('id', $requestInfo['userid'])
            ->update(['first_name' => $requestInfo['first_name'],'last_name' => $requestInfo['last_name'],'country' => $requestInfo['country'],'profile_image'=>$image_file,'height' => $requestInfo['height'],'weight' => $requestInfo['weight'],'team_name' => $requestInfo['team_name'],'position' => $requestInfo['position'],'member' => $requestInfo['member'],'college' => $requestInfo['college'],'debut' => $requestInfo['debut'],'updated_at' => $currentDateTime]);
		
  
         return redirect()->route('userdetails')
                        ->with('success','UsersDetails updated successfully');
    }

    public function deleteUserDetails(Request $request) {
    	//dd($request->toArray());
    	$requestInfo	=	$request->all();
		$userid 		=	$requestInfo['userid'];
		$id = $request->userid;
  		$userdetails = UserDetails::find($id);
  		//$data = UserDetails::find(1)->delete();
		//dd($userdetails);


    //	$data = UserDetails::find($userid)->delete();

    	//$userdetails =UserDetails::where('id','=',$userid)->first();
    	
    	//dd($userdetails);
        $userdetails->delete();
        return redirect()->route('userdetails')
                        ->with('success','UsersDetails deleted successfully');
    }

    public function getUsersDetails(Request $request) {

    	$orderKeys = ['first_name','last_name','country','debut'];
        $dataTableRequest = new DataTableRequest(UserRepository::class, $request, $orderKeys);		
        $params = [
            'orders' => $dataTableRequest->getOrderParams(),
            'keyword' => $dataTableRequest->getKeyword(),
        ];
        $dataTableRequest->setQueryParams($params)
            ->getListUsers(
                DataTableRequest::META_QUERY_TYPE,
                DataTableRequest::META_OFFSET,
                DataTableRequest::META_LIMIT,
                $params
            );
        return $dataTableRequest->getResponse();

    }

}
