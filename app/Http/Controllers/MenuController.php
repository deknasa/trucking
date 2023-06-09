<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class MenuController extends MyController
{
    public $title = 'Menu';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {

        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Menu',
            'combo' => $this->combo('list')
        ];

        return view('menu.index', compact('title', 'data'));
    }

    public function get($params = []): array
    {
        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
        ];

        $response = Http::withHeaders(request()->header())
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'menu', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? []
        ];


        return $data;
    }

    /**
     * Fungsi create
     * @ClassName create
     */
    public function create()
    {
        $title = $this->title;

        $data = [
            'nama' => '',
            'combo' => $this->combo('entry'),
            'class' => $this->listclassall(),
            'edit' => '0'
        ];

        return view('menu.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {

        $request['modifiedby'] = Auth::user()->name;
        $request['class'] = $this->listFolderFiles($request['controller']);

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->post(config('app.api_url') . 'menu', $request->all());

        return response($response, $response->status());
    }

    /**
     * Fungsi edit
     * @ClassName edit
     */
    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->get(config('app.api_url') . "menu/$id");

        $menu = $response['data'];
        $data = [
            'combo' => $this->combo('entry'),
            'class' => $this->listclassall(),

            'edit' => '1'
        ];

        return view('menu.edit', compact('title', 'menu', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = $this->listclassall();

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->withToken(session('access_token'))->patch(config('app.api_url') . "menu/$id", $request->all());

        return response($response, $response->status());
    }

    /**
     * Fungsi delete
     * @ClassName delete
     */
    public function delete($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "menu/$id");

        $menu = $response['data'];

        $data = [
            'nama' => '',
            'combo' => $this->combo('entry'),
            'class' => $this->listclassall(),
            'edit' => '0'
        ];

        return view('menu.delete', compact('title', 'menu', 'data'));
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->delete(config('app.api_url') . "menu/$id", $request->all());

        return response($response, $response->status());
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->get(config('app.api_url') . 'menu/field_length');

        return response($response['data'], $response->status());
    }

    /**
     * @ClassName
     */
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'menu', $request->all());

        $menus = $response['data'];


        return view('reports.menu', compact('menus'));
    }

    /**
     * @ClassName
     */
    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $menus = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Menu Name',
                'index' => 'menuname',
            ],
            [
                'label' => 'Menu Parent',
                'index' => 'menuparent',
            ],
            [
                'label' => 'Menu Icon',
                'index' => 'menuicon',
            ],
            [
                'label' => 'Aco ID',
                'index' => 'aco_id',
            ],
            [
                'label' => 'Link',
                'index' => 'link',
            ],
            [
                'label' => 'Menu Exe',
                'index' => 'menuexe',
            ],
            [
                'label' => 'Menu Kode',
                'index' => 'menukode',
            ],
        ];

        $this->toExcel($this->title, $menus, $columns);
    }


    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
        ];
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->get(config('app.api_url') . 'menu/combomenuparent', $status);

        return $response['data'];
    }


    public function getdata($aco_id)
    {
        $status = [
            'aco_id' => $aco_id,
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])->withToken(session('access_token'))
            ->get(config('app.api_url') . 'menu/getdatanamaacos', $status);

        return $response['data'];
    }

    public function listFolderFiles($controller)
    {
        $dir = base_path('app/http') . '/controllers/';
        $ffs = scandir($dir);
        unset($ffs[0], $ffs[1]);
        if (count($ffs) < 1)
            return;
        $i = 0;
        foreach ($ffs as $ff) {
            if (is_dir($dir . '/' . $ff))
                $this->listFolderFiles($dir . '/' . $ff);
            elseif (is_file($dir . '/' . $ff) && strpos($ff, '.php') !== false) {
                $classes = $this->get_php_classes(file_get_contents($dir . '/' . $ff));
                foreach ($classes as $class) {
                    if ($class == $controller) {


                        if (!class_exists($class)) {
                            include_once($dir . $ff);
                        }
                        $methods = $this->get_class_methods($class, true);

                        foreach ($methods as $method) {
                            if (isset($method['docComment']['ClassName'])) {
                                $data[] = [
                                    'class' => $class,
                                    'method' => $method['name'],
                                    'name' => $method['name'] . ' ' . $class
                                ];
                            }
                        }
                    }
                }
            }
        }
        return $data ?? '';
    }

    public function listclassall()
    {

        $dir = base_path('app/http') . '/controllers/';
        $ffs = scandir($dir);
        unset($ffs[0], $ffs[1]);
        if (count($ffs) < 1)
            return;
        $i = 0;
        $data[] = [
            'class' => 'NON CONTROLLER',
        ];
        foreach ($ffs as $ff) {
            if (is_dir($dir . '/' . $ff))
                $this->listFolderFiles($dir . '/' . $ff);
            elseif (is_file($dir . '/' . $ff) && strpos($ff, '.php') !== false) {
                $classes = $this->get_php_classes(file_get_contents($dir . '/' . $ff));
                foreach ($classes as $class) {

                    if (!class_exists($class)) {
                        include_once($dir . $ff);
                    }

                    $data[] = [
                        'class' => $class,
                    ];
                }
            }
        }
        return $data ?? '';
    }

    public function get_php_classes($php_code, $methods = false)
    {
        $classes = array();
        $tokens = token_get_all($php_code);

        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $classes[] = $tokens[$i][1]; // assigning class name to classes array variable

            }
        }
        return $classes;
    }

    public function get_class_methods($class, $comment = false)
    {
        $class = 'App\Http\Controllers' . '\\' . $class;
        $r = new ReflectionClass($class);
        $methods = array();

        foreach ($r->getMethods() as $m) {
            if ($m->class == $class) {
                $arr = ['name' => $m->name];
                if ($comment === true) {
                    $arr['docComment'] = $this->get_method_comment($r, $m->name);
                }

                $methods[] = $arr;
            }
        }

        return $methods;
    }
    public function get_method_comment($obj, $method)
    {
        $comment = $obj->getMethod($method)->getDocComment();
        //define the regular expression pattern to use for string matching
        $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";

        //perform the regular expression on the string provided
        preg_match_all($pattern, $comment, $matches, PREG_PATTERN_ORDER);
        $comments = [];
        foreach ($matches[0] as $match) {
            $comment = preg_split('/[\s]/', $match, 2);
            $comments[trim($comment[0], '@')] = $comment[1];
        }

        return $comments;
    }

    /**
     * @ClassName
     */
    public function resequence()
    {
        $title = $this->title;

        return view('menu.resequence', compact('title'));
    }

    /**
     * @ClassName
     */
    public function storeResequence(Request $request)
    {
        try {
            DB::beginTransaction();

            $menus = Menu::all();

            foreach ($menus as $menu) {
                $menu->menukode .= 'temp';
                $menu->menukode .= 'temp';
                $menu->save();
            }

            $this->_updateRecursiveMenu($request->menu);
            session(['menus' => (new Menu())->getMenu()]);

            DB::commit();

            return response([
                'message' => 'Berhasil disimpan'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    private function _updateRecursiveMenu($menus, $index = 0, $parent = 0, $level = 0)
    {
        foreach ($menus as $menuIndex => $menu) {
            $menuKode = 0;

            if (strtolower($menu['name']) === 'logout') {
                $menuKode = 'Z';
            } else {
                if ($level > 0) {
                    $menuIndex = $menuIndex + 1;
    
                    if (substr($index, 0, -$level) > 9) {
                        $index = range('A', 'Z')[$index - 10];
                    }
    
                    if ($menuIndex > 9) {
                        $menuIndex = range('A', 'Z')[$menuIndex - 10];
                    }
    
                    $menuKode = $index . $menuIndex;
                } else {
                    if ($menuIndex > 9) {
                        $menuIndex = range('A', 'Z')[$menuIndex - 10];
                    }
    
                    $menuKode = $menuIndex;
                }
            }
            
            $menuModel = Menu::findOrFail($menu['id']);
            $menuModel->menuparent = $parent;
            $menuModel->menukode = $menuKode;
            $menuModel->save();
            
            if (isset($menu['children'])) {
                $this->_updateRecursiveMenu($menu['children'], $menuKode, $menu['id'], $level + 1);
            }
        }
    }
}
