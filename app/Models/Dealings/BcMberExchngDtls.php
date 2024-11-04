<?php

namespace App\Models\Dealings;

use App\Models\History\BcCaCoinHis;
use App\Models\History\BcMberCoinHis;
use App\Models\User\BcMber;
use App\Models\User\BcMngr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcMberExchngDtls extends Model
{
    use HasFactory;

    protected $table = 'bc_mber_exchng_dtls';

    protected $primaryKey = 'mber_exchng_dtls_id';

    protected $guarded = [

    ];

    const UPDATED_AT = null;

    public function bcMber()
    {
        return $this->belongsTo( BcMber::class, 'mber_id' );
    }

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }

    public function bcCaCoinHis()
    {
        return $this->hasMany( BcCaCoinHis::class, 'mber_exchng_dtls_id' );
    }

    public function bcMberCoinHis()
    {
        return $this->hasMany( BcMberCoinHis::class, 'mber_exchng_dtls_id' );
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
        if($where == 'login_id')
        {
            return $query->whereHas('bcMber', function($q) use ($where, $keyword) {
                $q->where($where, 'like', '%'.$keyword.'%');
            });
        }
        if($where == 'nm')
        {
            return $query->whereHas('bcMber', function($q) use ($where, $keyword) {
                $q->where($where, 'like', '%'.$keyword.'%');
            });
        }
        if($where == 'mber_grd')
        {
            if(count($keyword) == 1)
            {
                return $query->where('mber_grd', $keyword[0]);
            }
            else
            {
                return $query->whereIn('mber_grd', $keyword);
            }
        }

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
