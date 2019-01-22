<?php

namespace App\Http\Controllers\User;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;
class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => bcrypt($request->password),
            'verified'           => User::UNVERIFIED_USER,
            'verification_token' => User::generateVerificationCode(),
            'admin'              => User::REGULAR_USER,
        ]);
        return $this->showOne($user,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if ($request->has('name'))
        {
            $user->name = $request->name;

        }

        if($request->has('email'))
        {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }
        if($request->has('password'))
        {
            $user->password = $request->password;
        }
        if($request->has('admin'))
        {
            if(!$user->isVerified())
            {
                return $this->errorResponse('only the verified users can modify the admin field',409);
            }
            $user->admin = $request->admin;
        }

        if(!$user->isDirty())
        {
            return $this->errorResponse('you need to specify different value to update',422);
        }
        $user->save();
        return $this->showOne($user,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user,200);
    }
    /**
     * verify user account 
     */
    public function verify($token)
    {
        $user = User::where('verification_token',$token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();
        return $this->showMessage('the account has been verified successfully',200);
    }
    /**
     * resend verify token user account 
     */
    public function resend(User $user)
    {
        if($user->isVerified())
                return $this->showMessage('this user is already verified',409);

        retry(5,function() use($user){
             Mail::to($user)->send(new UserCreated($user));
        },100);
        return $this->showMessage('the verification email has been resend');
    }
}
