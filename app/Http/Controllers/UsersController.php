<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : '';
        if($search != ''){
            $user = User::where('name','like','%'.$search.'%')->orWhere('email','like','%'.$search.'%')->paginate(10);
        }else{
            $user = User::paginate(10);
        }
        
        $titlebar = 'User List';
        $describebar = 'Seting / User';

        // load the view and pass the sharks
        return view('user.index',compact('user','search','titlebar','describebar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [ 
            'level' => Level::get(),
            'method' => 'POST',
            'action' => url('seting/user'),
            'titlebar' => 'Add User',
            'describebar' => 'Seting / User',
        ];
        return view('user.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name'   => 'required',
            'level_id'   => 'required',
            'email'   => 'required|unique:users',
            'password'   => 'required|confirmed',
        ]);

        $data = $request->only(['name','email','password','level_id']);
        $data['password'] = Hash::make($request->password);

        User::insert($data);
        return redirect('/seting/user')->with('success', 'User added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if($user){
            
            $data = [ 
                'level' => Level::get(),
                'method' => 'PUT',
                'action' => url('seting/user/'.$id),
                'user' => $user,
                'titlebar' => 'Edit User',
                'describebar' => 'Seting / User',
            ];
            return view('user.form',$data);
        }else{
         
            return Redirect::to("seting/user")->withErrors(['error' => 'User not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user){
            $data = $request->only(['name','email','level_id']);
            
            if($request->password != null && $request->password != ''){
                if($request->password !== $request->konfirmasi){
                    return redirect('/seting/user')->with('error', 'Password does not match');
                }else{
                    $data['password'] = Hash::make($request->password);
                }
            }

            User::where('id','=',$id)->update($data);
            return redirect('/seting/user')->with('success', 'User updated successfully');
        }else{
            return redirect('/seting/user')->withErrors('error', 'User not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            User::where('id','=',$id)->delete();
            return redirect('/seting/user')->with('success', 'User deleted successfully');
        }else{
            return redirect('/seting/user')->withErrors('error', 'User not found');
        }
    }
}
