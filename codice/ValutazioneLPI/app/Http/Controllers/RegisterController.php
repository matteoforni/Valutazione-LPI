<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function home(){
        return view('register/index');
    }

    public function register(Request $request)
    {
        print_r($request->all());
        $this->validate($request, [
            'name' => 'required|min:2|max:100',
            'surname' => 'required|min:2|max:100',
            'phone' => 'required|min:9',
            'email' => 'required|email',
            'password' => 'required|min:7',
        ]);
        $user = User::create($request->all());
        return response()->json($user, 201);
    }
}
?>