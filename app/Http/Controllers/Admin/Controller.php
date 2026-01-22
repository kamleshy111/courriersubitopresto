<?php


namespace App\Http\Controllers\Admin;


use Illuminate\Support\Str;

class Controller extends \App\Http\Controllers\Controller {
    public $name;
    public $model;
    public $options = [
        'autocomplete' => 'off'
    ];

    private function from_camel_case($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    public function __construct() {
        $class = explode('\\', get_class($this));
        $this->name = $this->from_camel_case(str_replace('Controller', '', array_pop($class)));
        $this->model = "\App\Models\\".ucfirst(Str::singular($this->name));

        $this->middleware('permission:admin.'.$this->name.'.index', ['only' => ['index']]);
        $this->middleware('permission:admin.'.$this->name.'.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.'.$this->name.'.show', ['only' => ['show']]);
        $this->middleware('permission:admin.'.$this->name.'.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin.'.$this->name.'.destroy', ['only' => ['destroy']]);
    }
}
