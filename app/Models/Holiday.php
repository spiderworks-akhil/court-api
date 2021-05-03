<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spiderworks\Webadmin\Models\BaseModel;
use Spiderworks\Webadmin\Traits\ValidationTrait;

class Holiday extends BaseModel
{
    use HasFactory;

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }


    protected $table = 'holiday';

    protected $fillable = array('name','date','is_business_open','surcharge');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'date' => 'required|date',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        return $this->parent_validate($data);
    }


}
