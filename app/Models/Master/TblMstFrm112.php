<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblMstFrm112 extends Model
{
    use HasFactory;

    protected $table = "TBL_MST_UDFFOR_RPF";

    protected $primaryKey = "UDFRPFID";

    public $timestamps = false;


}//class