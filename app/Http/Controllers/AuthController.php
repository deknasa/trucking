<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Libraries\Myauth;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $accessToken = $this->getAccessToken($request->user, $request->password);
            $emklAccessToken = $this->getEmklAccessToken(config('emkl.api.user'), config('emkl.api.password'));
            
            session(['access_token' => $accessToken]);
            session(['emkl_access_token' => $emklAccessToken]);
            session(['menus' => $this->getMenu()]);

            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withErrors([
                'user_not_found' => 'User not registered'
            ]);
        }
    }

    public function getAccessToken(string $user, string $password): string
    {
        $response = Http::accept('application/json')
            ->withoutVerifying()
            ->post(config('app.api_url') . 'token', [
                'user' => $user,
                'password' => $password
            ]);

        if (!$response->ok()) {
            throw new Exception('Error while fetching access token.');
        } else {
            return $response->json('access_token');
        }
    }

    public function getEmklAccessToken(string $user, string $password): string
    {
        $response = Http::accept('application/json')
            ->withoutVerifying()
            ->post(config('emkl.api.url') . '/auth/token', [
                'user' => $user,
                'password' => $password
            ]);

        if (!$response->ok()) {
            throw new Exception('Error while fetching EMKL access token.');
        } else {
            return $response->json('access_token');
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
