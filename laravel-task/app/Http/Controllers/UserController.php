<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * Display a listing of the user.
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = '';
        try {
            $data = User::where('roles', '=', 2)->orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 10);
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while fecth user details';
            Log::error($error);
        }
    }

    /**
     * Display a get Approve User
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function getApproveUser(Request $request)
    {
        $data = '';
        try {
            $data = User::orderBy('id','DESC')->paginate(10);
            return view('users.approve',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 10);
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while fecth user details';
            Log::error($error);
        }
    }

    /**
     * Display a user Index From Admin.
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function userIndexFromAdmin(Request $request)
    {
        $data = '';
        try {
            $data = User::orderBy('id','DESC')->paginate(10);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 10);
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while fecth user details';
            Log::error($error);
        }
    }


    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $roles = Role::pluck('name','name')->all();
            return view('users.create',compact('roles'));
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while create user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }


    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required'
            ]);


            $input = $request->all();
            $input['password'] = Hash::make($input['password']);


            $user = User::create($input);
            $user->assignRole($request->input('roles'));


            return redirect()->route('users.index')->with('success','User created successfully');
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while save user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }


    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            return view('users.show',compact('user'));
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while show user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }   


    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = User::find($id);
            $roles = Role::pluck('name','name')->all();
            $userRole = $user->roles->pluck('name','name')->all();


            return view('users.edit',compact('user','roles','userRole'));
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while edit user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }


    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'same:confirm-password',
                'roles' => 'required'
            ]);


            $input = $request->all();
            if(!empty($input['password'])){ 
                $input['password'] = Hash::make($input['password']);
            }else{
                $input = array_except($input,array('password'));    
            }


            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();


            $user->assignRole($request->input('roles'));


            return redirect()->route('users.index')->with('success','User updated successfully');
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while edit user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }


    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            User::find($id)->delete();
            return redirect()->route('users.index')->with('success','User deleted successfully');
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while edit user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }

    /**
     * Update the specified user approve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        try{
            $user = User::find($id);
            $user->IsApprove= 0;
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();


            $user->assignRole($request->input('roles'));
            return response()->json(['success'=>'Approved Successfully']);
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while edit user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }

    /**
     * Update the specified user Reject.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Reject($id)
    {
        try{
            $user = User::find($id);
            $user->IsApprove= 0;
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();


            $user->assignRole($request->input('roles'));
            return response()->json(['success'=>'Approved Successfully']);
        } catch(\Exception $e) {
            Log::error($e);
            $error='Error occured while edit user details';
            Log::error($error);
            $data = User::orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }

}
