<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblMstFrm102 extends Model
{
    use HasFactory;

    protected $table = "TBL_MST_UDFFOR_GEJ";

    protected $primaryKey = "UDFGEJID";

    public $timestamps = false;


}//class