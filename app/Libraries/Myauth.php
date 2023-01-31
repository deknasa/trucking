<?php

namespace App\Libraries;

use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use stdClass;

class Myauth
{
    public $isLogin, $userPK;
    private $exceptAuth = [
        'class' => [
            '',
            'dashboard',
            'logtrail',
            'tutupbuku',
            'pengembaliankasbankheader',
            'historipenerimaanstok',
            'historipengeluaranstok',
            'reportall',
            'reportneraca',
            'approvalbukacetak',
            'laporanbukubesar',
            'laporankasbank',
            'gudang',
            'user'
        ],
        'method' => [
            'gridtab',
            'grid',
            'operation',
            'export',
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
            'delete',
            'approval'
        ],
    ];

    public function auth($class = null, $method = null): void
    {
        $class = strtolower($class);
        $method = strtolower($method);

        if (!$this->_validatePermission($class, $method)) {
            abort(403, "You don't have access");
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
            ->where('acl.role_id', $userRole[0]->user_id ?? null);

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
