<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcMngrCrtfc extends Model
{
    use HasFactory;

    protected $table = 'bc_mngr_crtfc';

    protected $primaryKey = 'mngr_crtfc_id';

    protected $guarded = [

    ];

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }
}
