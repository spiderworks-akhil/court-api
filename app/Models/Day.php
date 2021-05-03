<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spiderworks\Webadmin\Models\BaseModel;
use Spiderworks\Webadmin\Traits\ValidationTrait;

class Day extends BaseModel
{
    use HasFactory;

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }


    protected $table = 'days';


    protected $fillable = array('name');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        return $this->parent_validate($data);
    }

    public function slots($court_id){
        return $this->hasMany('App\Models\Slots','day_id','id')->where('court_id',$court_id)->get();
    }



}
