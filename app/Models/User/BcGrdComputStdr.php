<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcGrdComputStdr extends Model
{
    use HasFactory;

    protected $table = 'bc_grd_comput_stdr';

    protected $primaryKey = 'grd_comput_stdr_id';

    protected $guarded = [

    ];

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }
}
