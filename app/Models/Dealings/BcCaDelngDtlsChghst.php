<?php

namespace App\Models\Dealings;

use App\Models\User\BcMngr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcCaDelngDtlsChghst extends Model
{
    use HasFactory;

    protected $table = 'bc_ca_delng_dtls_chghst';

    protected $primaryKey = 'ca_delng_dtls_chghst_id';

    protected $guarded = [

    ];

    const UPDATED_AT = null;

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }

    public function bcCaDelngDtls()
    {
        return $this->belongsTo( BcCaDelngDtls::class, 'ca_delng_dtls_id' );
    }

    public function scopeSearchBy($query, $keyword, $where)
    {
        if($where == 'delng_se')
        {
            return $query->whereHas('bcCaDelngDtls', function($q) use ($where, $keyword) {
                $q->where($where, $keyword);
            });
        }

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
