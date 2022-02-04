<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

class MenuController extends Controller
{
    public $title = 'Menu';
    public $httpHeader = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $params = [
                'offset' => (($request->page - 1) * $request->rows),
                'limit' => $request->rows,
                'sortIndex' => $request->sidx,
                'sortOrder' => $request->sord,
                'search' => json_decode($request->filters, 1) ?? [],
            ];

            $response = Http::withHeaders($request->header())
                ->get(config('app.api_url') . 'menu', $params);

            $data = [
                'total' => $response['attributes']['totalPages'] ?? [],
                'records' => $response['attributes']['totalRows'] ?? [],
                'rows' => $response['data'] ?? []
            ];


            return response($data);
        }


        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Menu',
            'combo' => $this->combo('list')
        ];

        return view('menu.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = $this->title;


        $data = [
            'nama' => '',
            'combo' => $this->combo('entry'),
            'edit' => '0'
        ];

        return view('menu.add', compact('title', 'data'));
    }

    public function store(Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(config('app.api_url') . 'menu', $request->all());

        return response($response);
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get(config('app.api_url') . "menu/$id");

        $menu = $response['data'];
        $data = [
            'nama' => $this->getdata($menu['aco_id'])['nama'],
            'combo' => $this->combo('entry'),
            'edit' => '1'
        ];

        //  dd($data);
        return view('menu.edit', compact('title', 'menu', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->patch(config('app.api_url') . "menu/$id", $request->all());

        return response($response);
    }

    public function delete($id)
    {
        try {
            $title = $this->title;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get(config('app.api_url') . "menu/$id");

            $menu = $response['data'];

            $data = [
                'nama' => '',
                'combo' => $this->combo('entry'),
                'edit' => '0'
            ];

            return view('menu.delete', compact('title', 'menu', 'data'));
        } catch (\Throwable $th) {
            return redirect()->route('menu.index');
        }
    }

    public function destroy($id, Request $request)
    {
        $request['modifiedby'] = Auth::user()->name;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->delete(config('app.api_url') . "menu/$id", $request->all());

        return response($response);
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeader)->get(config('app.api_url') . 'menu/field_length');

        return response($response['data']);
    }


    public function combo($aksi)
    {
        $status = [
            'status' => $aksi,
        ];
        $response = Http::withHeaders($this->httpHeader)
            ->get(config('app.api_url') . 'menu/combomenuparent', $status);

        return $response['data'];
    }


    public function getdata($aco_id)
    {
        $status = [
            'aco_id' => $aco_id,
        ];
        $response = Http::withHeaders($this->httpHeader)
            ->get(config('app.api_url') . 'menu/getdatanamaacos', $status);
        return $response['data'];
    }
    public function listFolderFiles($dir = null)
    {
        if ($dir === null) {
            $dir = config('app.apppath') . 'controllers/';
        }
        $ffs = scandir($dir);
        unset($ffs[0], $ffs[1]);
        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;
        $i = 0;
        foreach ($ffs as $ff) {
            if (is_dir($dir . '/' . $ff))
                $this->listFolderFiles($dir . '/' . $ff);
            elseif (is_file($dir . '/' . $ff) && strpos($ff, '.php') !== false) {
                 $classes = $this->get_php_classes(file_get_contents($dir . '/' . $ff));
                foreach ($classes as $class) {
                    if (!class_exists($class)) {
                        include_once($dir . $ff);
                    }
                    $methods = $this->get_class_methods($class, true);

                    foreach ($methods as $method) {
                        if (isset($method['docComment']['ClassName'])) {
                            echo $method['name'];
                            // $this->Macos->save(['class'=>$class, 'method'=>$method['name'], 'displayname'=>$method['docComment']['AclName'],'modifiedby'=>$_SESSION[SESSION_NAME.'username']]);
                        }
                    }
                }
            }
        }
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
        // dd($class);
         $class = 'App\Http\Controllers'.'\\'.$class;
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

        // dd($methods);
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

}
