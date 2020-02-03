<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function home(){
        return view('register/index');
    }

    public function register(Request $request)
    {
        $messages = [
            'required' => "Il campo :attribute deve essere specificato.",
            'min' => "Il campo :attribute deve essere di almeno :min caratteri",
            'max' => "Il campo :attribute deve essere di massimo :max caratteri"
        ];

        $validation = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'surname' => 'required|min:2|max:100',
            'phone' => 'required|min:9',
            'email' => 'required|email',
            'password' => 'required|min:7',
        ], $messages);
        
        if($validation->fails()){
            return response()->json($validation->errors(), '422');
        }

        $user = User::create($request->all());
        return response()->json($user, 201);
    }
}
?>