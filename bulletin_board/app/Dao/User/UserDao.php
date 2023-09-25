<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDao implements UserDaoInterface
{
  /**
   * To save user that from api request
   * @param array $validated Validated values from request
   * @return Object created user object
   */
  public function saveUser($validated)
  {
    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($validated['password']);
    $user->profile = $validated['profile'];
    $user->type = $validated['type'];
    $user->phone = $validated['phone'];
    $user->dob = $validated['dob'];
    $user->address = $validated['address'];
    $user->created_user_id = Auth::guard('api')->user()->id ?? 1;
    $user->updated_user_id = Auth::guard('api')->user()->id ?? 1;
    $user->save();
    return $user;
  }
}