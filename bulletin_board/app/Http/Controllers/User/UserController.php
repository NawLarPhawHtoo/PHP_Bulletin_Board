<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $authInterface;

    /**
     * Create a new controller instance.
     * @param AuthServiceInterface
     * @return void
     */
    public function __construct(AuthServiceInterface $authServiceInterface)
    {
        $this->middleware('auth');
        $this->authInterface = $authServiceInterface;
    }

    /**
     * To show registration view
     * @return View registration form
     */
    protected function showRegistrationView()
    {
        return view('auth.register');
    }

    /**
     * To check register form is valid or not
     *
     * @param UserRegisterRequest $request
     * @return View registration confirm
     */
    protected function submitRegistrationView(UserRegisterRequest $request)
    {
        $validated = $request->validated();
        return redirect()
            ->route('register.confirm')
            ->withInput();
    }


    /**
     * To show registration view
     * @return View registration confirm view
     */
    protected function showRegistrationConfirmView()
    {
        if(old()) {
            return view('auth.register-confirm');
        }
        return redirect()
            ->route('userlist');
    }

    /**
     * To submit register confirm and save user info to DB
     * @return View user list
     */
    protected function submitRegistrationConfirmView(Request $request)
    {
        $user = $this->authInterface->saveUser($request);
        return redirect()->route('userlist');
    }
}
