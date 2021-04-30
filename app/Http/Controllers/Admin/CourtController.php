<?php

namespace App\Http\Controllers\Admin;

use App\Models\Court;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use Spiderworks\Webadmin\Traits\ResourceTrait;
use Yajra\DataTables\DataTables;

class CourtController extends BaseController
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Court();
        $this->route = 'admin.court';
        $this->views = 'admin.court';

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'name','created_at','status','updated_at')->orderby('id','DESC');
    }

    protected function initDTData($collection, $queries = []) {
        $route = $this->route;
        return DataTables::of($collection)
            ->setRowId('row-{{ $id }}')
            ->editColumn('status', function($obj) use($route) {
                if($obj->status == 1)
                {
                    return '<a href="' . route($route.'.change-status', [encrypt($obj->id)]).'" class=" btn-sm webadmin-btn-warning-popup" data-message="Are you sure, want to disable this record?" style="color: red !important">Disable</a>';
                }else{
                    return '<a href="' . route($route.'.change-status', [encrypt($obj->id)]) . '" class=" btn-sm webadmin-btn-warning-popup" data-message="Are you sure, want to enable this record?">Enable</a>';
                }
            })
            ->addColumn('action_edit', function($obj) use ($route, $queries) {
                return '<a href="'.route($route.'.edit', [encrypt($obj->id)]).'" class="" title="' . ($obj->updated_at ? 'Last updated at : ' . date('d/m/Y - h:i a', strtotime($obj->updated_at)) : ''). '" ><i class="fa fa-pencil"></i></a>';
            })
            ->addColumn('action_delete', function($obj) use ($route, $queries) {
                return '<a href="'.route($route.'.destroy', [encrypt($obj->id)]).'" class="webadmin-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." title="' . ($obj->updated_at ? 'Last updated at : ' . date('d/m/Y - h:i a', strtotime($obj->updated_at)) : '') . '"><i class="fa fa-trash"></i></a>';
            })->rawColumns(['action_edit','action_delete','status']);
    }





}
