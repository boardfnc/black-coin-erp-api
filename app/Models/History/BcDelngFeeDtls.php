<?php

namespace App\Models\History;

use App\Models\Dealings\BcCaDelngDtls;
use App\Models\Dealings\BcMberDelngDtls;
use App\Models\User\BcMber;
use App\Models\User\BcMngr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcDelngFeeDtls extends Model
{
    use HasFactory;

    protected $table = 'bc_delng_fee_dtls';

    protected $primaryKey = 'delng_fee_dtls_id';

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

    public function bcMberDelngDtls()
    {
        return $this->belongsTo( BcMberDelngDtls::class, 'mber_delng_dtls_id' );
    }

    public function bcCaDelngDtls()
    {
        return $this->belongsTo( BcCaDelngDtls::class, 'ca_delng_dtls_id' );
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
        if($where == 'mber_grd')
        {
            if(count($keyword) == 1)
            {
                if($keyword[0] == '5')
                {
                    return $query->whereNull('mber_grd');
                }
                else
                {
                    return $query->where('mber_grd', $keyword[0]);
                }
            }
            else
            {
                if(in_array('5', $keyword))
                {
                    $key = array_search('5', $keyword, true);
                    if ($key !== false) {
                        unset($keyword[$key]);
                    }

                    return $query->whereIn('mber_grd', $keyword)->orWhereNull('mber_grd');
                }
                else
                {
                    return $query->whereIn('mber_grd', $keyword);
                }
            }
        }

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
