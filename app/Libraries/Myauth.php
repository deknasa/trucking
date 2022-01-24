<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Myauth
{

    private $server, $user, $pass, $db;
    public $isLogin, $userPK;
    private $conn;
    private $authController;
    private $exceptAuth = [
        'class' => ['useracl', 'login', 'home', 'relasi', 'extension', 'logout', 'acos', 'dashboard', 'combo', 'help', 'test'],
        'method' => ['gridtab', 'grid', 'operation', 'excel', 'crud', 'carishippersama', 'listmarketingcabang', 'good', 'nonaktif', 'field_data', 'griddetail', 'detail', 'show', 'cetak', 'getdetail', 'report'],
    ];

    public function __construct($params)
    {
        $url = URL::to('/');
        $this->server = $params['server'];
        $this->user = $params['user'];
        $this->pass = $params['pass'];
        $this->db = $params['db'];
        $this->port = isset($params['port']) ? $params['port'] : 3306;
        $this->isLogin = isset($params['isLogin']) ? $params['isLogin'] : 0;
        $this->userPK = $params['userPK'];
        $this->baseUrl = $url;
        $this->authController = isset($params['authController']) ? $params['authController'] : 'login';
    }

    public function auth($class = null, $method = null)
    {
        $class = strtolower($class);
        $method = strtolower($method);
        
        if (!$this->_validatePermission($class, $method)) {
            exit("You don't have access");
        }
    }

    public function hasPermission($class, $method)
    {
        $class = strtolower($class);
        $method = strtolower($method);

        return Myauth::_validatePermission($class, $method);
    }

    private function _validatePermission($class = null, $method = null)
    {
        $myauth = new Myauth(
            [
                'server' => 'web.transporindo.com',
                'user' => 'sa',
                'pass' => 'MDF123!@#ldf1411',
                'db' => 'Trucking',
                'isLogin' => 1,
                // 'isLogin' => isset($_SESSION[SESSION_NAME . 'logged_in']) ? 1 : 0,
                'userPK' => 1,
                // 'userPK' => isset($_SESSION[SESSION_NAME . 'userpk']) ? $_SESSION[SESSION_NAME . 'userpk'] : 0,
                // 'baseUrl' => route('welcome')
            ]
        );
        if ($myauth->isLogin == 0) {
            if ($class != $this->authController) {
                if (strtolower($class) != 'extension') {
                    header("Location: " . $this->baseUrl . '/' . $this->authController);
                    exit();
                }
            }
        }

        // check except for class
        if (in_array($class, $myauth->exceptAuth['class'])) {
            return true;
        }

        $user = new \StdClass;
        // $user = multi_query("select fid,fuser_id,frole_id
        //     from tuserrole
        //     where fuser_id={$this->userPK}", "pst", $this->db);
        $user = DB::table('userrole')->select(['userrole.id', 'userrole.user_id', 'userrole.role_id'])->where('user_id', '=', $myauth->userPK)->get();


        if (empty($user)) {
            $user[0]->role_id = '';
        }

        $data_union = DB::table('acos')->select(['acos.id', 'acos.class', 'acos.method'])->join('acl', 'acos.id', '=', 'acl.aco_id')->where('acos.class', 'like', '%' . $class . '%')->where('acl.role_id', '=', $user[0]->role_id);

        $data = DB::table('acos')->join('useracl', 'acos.id', '=', 'useracl.aco_id')->where('acos.class', 'like', '%' . $class . '%')->where('useracl.user_id', '=', $myauth->userPK)->unionAll($data_union)->get(['acos.id', 'acos.class', 'acos.method'])->toArray();


        $acos = @$data;
        $acos = (array) $acos;
        if (empty($acos)) {
            return false;
        }

        if ($myauth->in_array_custom($method, $acos) == false && in_array($method, $myauth->exceptAuth['method']) == false) {
            return false;
        }

        return true;
    }

    function in_array_custom($item, $array)
    {
        // php > 5.5
        // $found = array_search($item, array_column($array, 'method'));
        // php all


        // $as = array_map(function ($v) {
        //     return strtolower($v['method']);
        // }, $array);

        // dd($as);
        // dd($array);

        $found =  array_search(
            $item,
            // $array->map(function ($v) {
            //     return $v['method'];
            // }),
            array_map(
                function ($v) {
                    return strtolower($v->method);
                },
                $array
            )
        );
        return empty($found) && $found !== 0 ? false : true;
    }
}
