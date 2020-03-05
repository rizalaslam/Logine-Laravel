<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function doLogin(Request $req)
    {
        // dd($req->email);
    $var = array (
        'email' => $req->email, 
        'password' => $req->password
    );

    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_URL, "https://fathomless-sands-25021.herokuapp.com/api/auth/login");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $var);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    $outputs = json_decode($output, true);
    // dd($outputs["token"]);
    if ($outputs["status"] == 401)
    {
        return redirect()->back()->with('error','eror_set');
    }
    else
    {
        session([
            'bearer' => $outputs["token"],
            'username'=> $outputs["user"][0]["username"]
        ]);

        return redirect('dashboard');
    }
   
    
    // echo $output;
}
}
