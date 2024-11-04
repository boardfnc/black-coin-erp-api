<?php

namespace App\Models\Dealings;

use App\Models\History\BcCaCoinHis;
use App\Models\History\BcDelngFeeDtls;
use App\Models\User\BcMngr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcCaDelngDtls extends Model
{
    use HasFactory;

    protected $table = 'bc_ca_delng_dtls';

    protected $primaryKey = 'ca_delng_dtls_id';

    protected $guarded = [

    ];

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }

    public function bcCaDelngDtlsChghst()
    {
        return $this->hasMany( BcCaDelngDtlsChghst::class, 'ca_delng_dtls_id' );
    }

    public function bcCaCoinHis()
    {
        return $this->hasMany( BcCaCoinHis::class, 'ca_delng_dtls_id' );
    }

    public function bcDelngFeeDtls()
    {
        return $this->hasMany( BcDelngFeeDtls::class, 'ca_delng_dtls_id' );
    }

    public function scopeSearchBy($query, $keyword, $where)
    {
        if($where == 'created_at_start')
        {
            return $query->where('created_at', '>=', $keyword.' 00:00:00');
        }
        if($where == 'created_at_end')
        {
            return $query->where('created_at', '<=', $keyword.' 23:59:59');
        }
        if($where == 'delng_no')
        {
            return $query->where('delng_no', 'like', '%'.$keyword.'%');
        }
        if($where == 'login_id')
        {
            return $query->whereHas('bcMngr', function($q) use ($where, $keyword) {
                $q->where($where, 'like', '%'.$keyword.'%');
            });
        }
        if($where == 'prtnr_nm')
        {
            return $query->whereHas('bcMngr', function($q) use ($where, $keyword) {
                $q->where($where, 'like', '%'.$keyword.'%');
            });
        }
        if($where == 'code')
        {
            return $query->whereHas('bcMngr', function($q) use ($where, $keyword) {
                $q->where($where, 'like', '%'.$keyword.'%');
            });
        }
        if($where == 'delng_se')
        {
            return $query->where('delng_se', $keyword);
        }
        if($where == 'delng_sttus')
        {
            if(count($keyword) == 1)
            {
                return $query->where('delng_sttus', $keyword[0]);
            }
            else
            {
                return $query->whereIn('delng_sttus', $keyword);
            }
        }
        if($where == 'dpstr')
        {
            return $query->where('dpstr', 'like', '%'.$keyword.'%');
        }
        if($where == 'acnutno')
        {
            return $query->where('acnutno', 'like', '%'.$keyword.'%');
        }

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
