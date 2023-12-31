<?php

namespace App\Http\Controllers\User;

use App\Events\StaffLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ActiveLicense;
use App\Models\License;
use App\Models\Staff;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('user.authen.login');
    }

    public function login_post()
    {
        try {
            $data = request()->all();

            $rules = array(
                'email' => 'required|email|exists:staffs,email',
                'password' => 'required',
            );
            $messages = array(
                'email.required' => 'Nhập email!',
                'email.email' => 'Email chưa đúng định dạng!',
                'email.exists' => 'Không tồn tại tài khoản này!',
                'password.required' => 'Nhập mật khẩu!',
            );
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                $error = $validator->errors()->all();
                $msg = array_shift($error);
                return redirect()->back()->with('error', $msg);
            }

            $staff = Staff::ofEmail(request('email'))->ofStatus(Staff::STATUS_ACTIVE)->first();
            if (!$staff || !Hash::check(request('password'), $staff->password)) {
                return redirect()->back()->with('error', 'Đăng nhập thất bại!');
            }
            event(new StaffLogin($staff));
            return redirect()->route('index')->with('success', 'Đăng nhập thành công');
        } catch (\Throwable $th) {
            showLog($th);
            return redirect()->back()->with('error', 'Đăng nhập thất bại!');
        }
    }

    public function forgot_password()
    {
        return view('user.authen.forgot_password');
    }

    public function forgot_password_post()
    {
    }

    public function reset()
    {
        return view('user.authen.reset');
    }

    public function reset_post()
    {
    }

    public function license()
    {
        return view('user.authen.license');
    }

    public function license_active(ActiveLicense $request)
    {
        $license = License::with('store')->ofKey($request->license)->ofStatus(License::STATUS_UN_ACTIVE)->first();
        if ($license && $license->store) {
            $license->status = License::STATUS_ACTIVE;
            $license->save();
            $license->store->status = Store::STATUS_ACTIVE;
            $license->store->save();
            return redirect()->route('login')->with('success', 'Kích hoạt license thành công');
        }
        return redirect()->route('login')->with('error', 'Lỗi kích hoạt!');
    }
}