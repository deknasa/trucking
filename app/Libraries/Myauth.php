<?php

namespace App\Libraries;

use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use stdClass;

class Myauth
{
    private $server, $user, $pass, $db;
    public $isLogin, $userPK;
    private $conn;
    private $authController;
    private $exceptAuth = [
        'class' => [
            '',
            'useracl',
            'login',
            'home',
            'relasi',
            'extension',
            'logout',
            'acos',
            'dashboard',
            'combo',
            'help',
            'test',
            'parameter',
            'user',
            'role',
            'menu',
            'userrole',
            'error',
            'acl',
            'cabang',
            'absensisupir',
            'logtrail',
            'agen',
            'akunpusat',
            'kasgantung',
            'supplier',
            'penerima',
            'pelanggan',
            'statuscontainer',
            'absentrado',
            'bank',
            'mekanik',
            'container',
            'akunpusat',
            'alatbayar',
            'bank',
            'bankpelanggan',
            'gudang',
            'jenisemkl',
            'jenisorder',
            'jenistrado',
            'kategori',
            'kelompok',
            'kerusakan',
            'kota',
            'mandor',
            'merk',
            'orderantrucking',
            'pelanggan',
            'penerima',
            'penerimaantrucking',
            'pengeluarantrucking',
            'prosesabsensisupir',
            'ritasi',
            'satuan',
            'statuscontainer',
            'subkelompok',
            'supir',
            'supplier',
            'suratpengantar',
            'trado',
            'upahritasi',
            'upahsupir',
            'zona',
            'tarif',
            'servicein',
            'serviceout',

        ],
        'method' => [
            'gridtab',
            'grid',
            'operation',
            'excel',
            'crud',
            'carishippersama',
            'listmarketingcabang',
            'good',
            'nonaktif',
            'fieldlength',
            'griddetail',
            'detail',
            'show',
            'cetak',
            'getdetail',
            'report',
            'create',
            'add',
            'delete'
        ],
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

    public function auth($class = null, $method = null): void
    {
        $class = strtolower($class);
        $method = strtolower($method);

        if (!$this->_validatePermission($class, $method)) {
            abort(401, "You don't have access");
        }
    }

    public function hasPermission($class, $method)
    {
        $class = strtolower($class);
        $method = strtolower($method);

        return $this->_validatePermission($class, $method);
    }

    private function _validatePermission($class = null, $method = null)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        /* Check if $class is in exception */
        if (in_array(strtolower($class), $this->exceptAuth['class'])) {
            return true;
        }
        
        $userRole = DB::table('userrole')
            ->where('user_id', Auth::user()->id)
            ->get();
        
        $data_union = DB::table('acos')
            ->select(['acos.id', 'acos.class', 'acos.method'])
            ->join('acl', 'acos.id', '=', 'acl.aco_id')
            ->where('acos.class', 'like', "%$class%")
            ->where('acl.role_id', $userRole[0]->user_id);

        $data = DB::table('acos')
            ->select(['acos.id', 'acos.class', 'acos.method'])
            ->join('useracl', 'acos.id', '=', 'useracl.aco_id')
            ->where('acos.class', 'like', "%$class%")
            ->where('useracl.user_id', Auth::user()->id)
            ->unionAll($data_union)
            ->get();
        
        if ($this->in_array_custom($method, $data->toArray()) == false && in_array($method, $this->exceptAuth['method']) == false) {
            return false;
        }
        
        return true;
    }

    public function in_array_custom($item, $array): bool
    {
        $found =  array_search(
            $item,
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
