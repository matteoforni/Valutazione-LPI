<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getUser($id)
    {
        return response()->json(User::find($id));
    }
}
?>