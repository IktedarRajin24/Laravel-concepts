<?php

namespace App\Http\Controllers;
use App\Models\AuthUser;

use Illuminate\Http\Request;

class userControllerAPI extends Controller
{
    public function registration(Request $request){
        if($request->hasFile('image')){
            $imageName = time() . '-' . $request->name . '.' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
            $users = new AuthUser();
            $users->name = $request->name;
            $users->email = $request->email;
            $users->gender = $request->gender;
            $users->image = $imageName;
            $users->phone = $request->phone;
            $users->password = $request->password;
            $users->save();

            return response()->json('Insert');
        }
        else{
            return response()->json('failed');
        }

        

    }

    public function viewAllUsers()
    {
        $users = AuthUser::all()->where('is_admin', 0);
        return $users;
    }
}
