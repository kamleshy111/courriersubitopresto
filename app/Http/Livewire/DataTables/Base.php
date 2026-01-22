<?php

namespace App\Http\Livewire\DataTables;

use App\Models\Client;
use App\Models\Waybill;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Mediconesystems\LivewireDatatables\ColumnSet;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Base extends LivewireDatatable {
    public $perPage = 10;

    public function builder() {
        if(\Laratrust::hasRole('admin'))
            return parent::builder();
        elseif(in_array(substr($this->model, 1), [Waybill::class, Client::class])) {;
            return  parent::builder()->where('user_id', \Auth::id());
        } else {
            return parent::builder();
        }
    }

    public function columns() {
        try {
            $model = parent::columns();
            $colset = ColumnSet::fromModelInstance(parent::columns())->columns->toArray();
        } catch(ModelNotFoundException $e) {
            $model = new $this->model;
            $colset = collect(\Schema::getColumnListing($model->getTable()))->reject(function ($name) use ($model) {
                    return in_array($name, $model->getHidden());
                })->map(function ($attribute) {
                    return Column::name($attribute);
                })->toArray();
        }

        //Grab model to find the base action
        $actionBase = "admin." . Str::of($this->model)->afterLast('\\')->plural()->lower();

        $colset[] = Column::callback(['id'], function ($id) use ($actionBase) {
            return view('admin.CRUD.actions', compact('id', 'actionBase'));
        });
        return $colset;
    }
}
