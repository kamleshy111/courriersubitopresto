<?php
namespace App\Http\Controllers\Admin;



use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;

class CRUDController extends Controller {
	public $inject = ['readonly' => null];
	public $sync = [];
	public $with = [];

	public function __construct() {
		parent::__construct();
		$this->inject['name'] = $this->name;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index() {
	    $this->inject["model"] = $this->model;
		return view($this->_getViewName('CRUD.index'), $this->inject);
	}

	public function getRedirectUrl() {
		if(session()->has('redirectUrl') && !in_array($this->name, ['roles', 'permissions'])) {
			return session()->pull('redirectUrl');
		}
		return null;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view($this->_getViewName('CRUD.edit'), $this->inject);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {
		$validator = Validator::make($request->all(), (new $this->model())->rules);

		if ($validator->fails()) {
			return redirect(route('admin.'.$this->name . '.create'))
				->withErrors($validator)
				->withInput($request->input());
		} else {
			// store
			$model = new $this->model();
			$model->fill($request->input());
			$model->save();

			if(!empty($this->sync) && is_array($this->sync)) {
				foreach($this->sync as $sync) {
					$model->$sync()->sync($request->input($sync));
				}
			}

			if(!empty($request->file())) {
				foreach($request->file() as $type => $file) {
					if(is_array($file)) {
						foreach($file as $k => $f) {
							/** @var $file \Illuminate\Http\UploadedFile */
							File::saveFile($model, time().'_'.$k.'_'.$f->getClientOriginalName(), $f->get(), $f->getClientOriginalName(), $type);
						}
					} else {
						/** @var $file \Illuminate\Http\UploadedFile */
						File::saveFile($model, time() . '_' . $file->getClientOriginalName(), $file->get(), $file->getClientOriginalName(), $type);
					}
				}
			}
			$this->model = $model;
			// redirect
			$request->session()->flash('message', ['success', ucfirst($this->name) . ' crée !']);
			return redirect($this->getRedirectUrl() ?? route('admin.'.$this->name . '.index'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		return $this->edit($id, true);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, $readonly = false) {
		$this->inject['model'] = $this->model::with(empty($this->with) ? $this->sync : $this->with)->findOrFail($id);
        $this->inject['readonly'] = $readonly;
		return view($this->_getViewName('CRUD.edit'), $this->inject);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
	 */
	public function update(Request $request, $id) {
		$_model = (new $this->model());
		$validator = Validator::make($request->all(), property_exists($_model, 'rules_update') ? $_model->rules_update : $_model->rules);

		if ($validator->fails()) {
			return redirect(route('admin.'.$this->name . '.edit', $id ))
				->withErrors($validator)
				->withInput($request->input());
		} else {
			// store
			$model = $this->model::findOrFail($id);

			if(empty($request->input('password'))) {
				$model->update($request->except(['password']));
			} else {
				$model->update($request->input());
			}

			if(!empty($request->file())) {
				foreach($request->file() as $type => $file) {
					//$model->files($type)->delete();
					if(is_array($file)) {
						foreach($file as $k => $f) {
							/** @var $file \Illuminate\Http\UploadedFile */
							File::saveFile($model, time().'_'.$k.'_'.$f->getClientOriginalName(), $f->get(), $f->getClientOriginalName(), $type);
						}
					} else {
						/** @var $file \Illuminate\Http\UploadedFile */
						File::saveFile($model, time() . '_' . $file->getClientOriginalName(), $file->get(), $file->getClientOriginalName(), $type);
					}
				}
			}

			if(!empty($this->sync) && is_array($this->sync)) {
				foreach($this->sync as $sync) {
					if($request->exists($sync)) {
						$model->$sync()->sync($request->input($sync));
					}
				}
			}
			$this->model = $model;
			//redirect
			$request->session()->flash('message', ['success', 'Mis à jour avec succès !']);
			return redirect( $this->getRedirectUrl() ?? route('admin.'.$this->name . '.index'));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$this->model::findOrFail($id)->delete();
		return "true";
	}

	public function _getViewName($string) {
		$string = 'admin.'.$string;
		$view = str_replace('CRUD', $this->name, $string);
		return view()->exists($view) ? $view : $string;

	}
}
