<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcCmmnCd extends Model
{
    use HasFactory;

    protected $table = 'bc_cmmn_cd';

    protected $primaryKey = ['cd_grp', 'cd'];

    public $incrementing = false;
}
