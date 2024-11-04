<?php

namespace App\Models\User;

use App\Models\Dealings\BcMberDelngDtls;
use App\Models\Dealings\BcMberDelngDtlsChghst;
use App\Models\Dealings\BcMberExchngDtls;
use App\Models\Dealings\BcMberPymntDtls;
use App\Models\Dealings\BcMberRtrvlDtls;
use App\Models\History\BcDelngFeeDtls;
use App\Models\History\BcMberCoinHis;
use App\Models\History\BcMberStats;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcMber extends Model
{
    use HasFactory;

    protected $table = 'bc_mber';

    protected $primaryKey = 'mber_id';

    public $timestamps = false;

    protected $guarded = [

    ];

    protected $hidden = [
        'password',
    ];

    public function bcMngr()
    {
        return $this->belongsTo( BcMngr::class, 'mngr_id' );
    }

    public function bcMberDelngDtls()
    {
        return $this->hasMany( BcMberDelngDtls::class, 'mber_id' );
    }

    public function bcMberDelngDtlsChghst()
    {
        return $this->hasMany( BcMberDelngDtlsChghst::class, 'mber_id' );
    }

    public function bcMberExchngDtls()
    {
        return $this->hasMany( BcMberExchngDtls::class, 'mber_id' );
    }

    public function bcMberPymntDtls()
    {
        return $this->hasMany( BcMberPymntDtls::class, 'mber_id' );
    }

    public function bcMberRtrvlDtls()
    {
        return $this->hasMany( BcMberRtrvlDtls::class, 'mber_id' );
    }

    public function bcDelngFeeDtls()
    {
        return $this->hasMany( BcDelngFeeDtls::class, 'mber_id' );
    }

    public function bcMberCoinHis()
    {
        return $this->hasMany( BcMberCoinHis::class, 'mber_id' );
    }

    public function bcMberStats()
    {
        return $this->hasMany( BcMberStats::class, 'mber_id' );
    }

    public function scopeSearchBy($query, $keyword, $where)
    {
        if($where == 'sbscrb_dt_start')
        {
            return $query->where('sbscrb_dt', '>=', $keyword.' 00:00:00');
        }
        if($where == 'sbscrb_dt_end')
        {
            return $query->where('sbscrb_dt', '<=', $keyword.' 23:59:59');
        }
        if($where == 'login_id')
        {
            return $query->where($where, 'like', '%'.$keyword.'%');
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
        if($where == 'mber_grd')
        {
            return $query->where('mber_grd', $keyword);
        }
        if($where == 'mber_sttus')
        {
            return $query->where('mber_sttus', $keyword);
        }
        if($where == 'confm_sttus')
        {
            return $query->where('confm_sttus', $keyword);
        }

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
