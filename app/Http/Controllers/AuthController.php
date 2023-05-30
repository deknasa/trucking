<?php

namespace App\Http\Controllers;

use App\Libraries\Myauth;
use App\Models\Menu;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Login';

        return view('login', compact('title'));
    }

    /**
     * To proccess login
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return void
     */
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required'
        ]);
        
        $credentials = [
            'user' => $request->user,
            'password' => $request->password
        ];

        $credentialsEmkl = [
            'grant_type' => 'client_credentials',
            'client_id' => config('app.emkl_client_id'),
            'client_secret' => config('app.emkl_client_secret')
        ];



        if (Auth::attempt($credentials)) {
            $token = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
            ->post(config('app.api_url') . 'token', $credentials);

           
            // $tokenEmkl = Http::withHeaders([
            //     'Accept' => 'application/json'
            // ])->withOptions(['verify' => false])
            // ->post(config('app.emkl_api_url') . 'oauth/token', $credentialsEmkl);

            // dd($tokenEmkl->getBody()->getContents());
            
            // session(['access_token' => $token['access_token']]);
            // session(['access_token_emkl' => $tokenEmkl['access_token']]);
            session(['menus' => $this->getMenu()]);

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors([
                'user_not_found' => 'User not registered'
            ]);
        }
    }

    public function getMenu($induk = 0)
    {
        $data = [];

        $menu = Menu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
            ->where('menu.menuparent', $induk)
            ->orderby(DB::raw('right(menukode,1)'), 'ASC')
            ->get(['menu.id', 'menu.aco_id', 'menu.menuseq', 'menu.menuname', 'menu.menuicon', 'acos.class', 'acos.method', 'menu.link', 'menu.menukode', 'menu.menuparent']);

        foreach ($menu as $index => $row) {
            $hasPermission = (new Myauth())->hasPermission($row->class, $row->method);

            if ($hasPermission || $row->class == null) {
                $data[] = [
                    'menuid' => $row->id,
                    'aco_id' => $row->aco_id,
                    'menuname' => $row->menuname,
                    'menuicon' => $row->menuicon,
                    'link' => $row->link,
                    'menuno' => substr($row->menukode, -1),
                    'menukode' => $row->menukode,
                    'menuexe' => $row->class . "/" . $row->method,
                    'class' => $row->class,
                    'child' => $this->getMenu($row->id),
                    'menuparent' => $row->menuparent,
                ];
            }
        }

        return $data;
    }

    public function logout()
    {
        Auth::logout();

        session()->forget('menus');
        
        return redirect()->route('login');
    }

}
