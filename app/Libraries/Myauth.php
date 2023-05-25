<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;
class Myauth
{
    public $isLogin, $userPK;
    private $exceptAuth = [
        'class' => [
            '',
            'dashboard',
            'logtrail',
            'tutupbuku',
            'approvalbukacetak',
            'approvalsupirgambar',
            'historipenerimaanstok',
            'historipengeluaranstok',
            'reportall',
            'reportneraca',
            'invoicechargegandenganheader',
            'pengembaliankasbankheader',
            'laporanbukubesar',
            'laporankasbank',
            'penerimaanstokdetail',
            'pengeluaranstokdetail',
            'gudang',
            'user',
        ],
        'method' => [
            'gridtab',
            'grid',
            'operation',
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
            'create',
            'add',
            'delete',
            // 'approval',
            'export',
            'report',
            'aclgrid',
            'detailgrid',
            'historygrid',
            'piutanggrid',
            'jurnalgrid',
            'penerimaangrid',
            'pengeluarangrid',
            'kasgantunggrid',
            'hutanggrid',
            'potsemuagrid',
            'potpribadigrid',
            'depositogrid',
            'pelunasangrid',
            'transfergrid',
            'absensigrid',
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
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        /* Check if $class is in exception */
        if (in_array(strtolower($class), $this->exceptAuth['class'])) {
            return true;
        }
        
        $data_union = DB::table('acos')
            ->select(['acos.id', 'acos.class', 'acos.method'])
            ->join('acl', 'acos.id', '=', 'acl.aco_id')
            ->where('acos.class', 'like', "%$class%")
            ->whereIn('acl.role_id', auth()->user()->roles->pluck('id')->toArray() ?? null);

        $data = DB::table('acos')
            ->select(['acos.id', 'acos.class', 'acos.method'])
            ->join('useracl', 'acos.id', '=', 'useracl.aco_id')
            ->where('acos.class', 'like', "%$class%")
            ->where('useracl.user_id', auth()->user()->id)
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
