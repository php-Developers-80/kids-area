<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
    /**
     * @Check if admin soft delete
     *
     *
     */

    public function checkIfSoftDelete($user)
    {
        if ($user->deleted_at != null) {
            return true;
        }
        if ($user->is_block != "blocked") {
            return true;
        }
        return false;

    }


    /**
     * @return
     * login view
     *
     */
    public function showLoginForm()
    {
        if (!auth()->check()){
            return view('admin.auth.login');
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * make login
     *
     */
    public function login(\Illuminate\Http\Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'user_name'   => 'required',
            'password' => 'required|min:2'
        ]);

        //check the admin auth
        $rememberme = request('remember_me') == 1?true:false;
        if (auth()->attempt(['user_name' => request('user_name'), 'password' => request('password')], $rememberme)) {
            $user = auth()->user();

            //check if the user not blacked
            if (!$this->checkIfSoftDelete($user)) {
                $user->update([
                    'is_login'=>'not_connected',
                    'logout_time'=>time()
                ]);
                auth()->logout();
                return response(['message'=>'data'],500);
            }

            $user->update(['is_login'=>'connected', 'logout_time'=>null]);

            return response([
                'message'=>'data',
                'router'=>$user->user_type != 'admin'?route('cashier.index'):route('admin.dashboard')
                ],200);
        }
        //invalid data
       return response(['message'=>'data'],500);
    }

    /**
     * @return
     * logout
     *
     */
    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->update(['is_login'=>'not_connected', 'logout_time'=>time()]);
        auth()->logout();
        return redirect()->route('login');
    }

}//end class
