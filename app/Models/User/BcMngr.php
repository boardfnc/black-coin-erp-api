<?php

namespace App\Models\User;

use App\Models\Dealings\BcCaDelngDtls;
use App\Models\Dealings\BcCaDelngDtlsChghst;
use App\Models\Dealings\BcMberDelngDtls;
use App\Models\Dealings\BcMberExchngDtls;
use App\Models\Dealings\BcMberPymntDtls;
use App\Models\Dealings\BcMberRtrvlDtls;
use App\Models\History\BcCaStats;
use App\Models\History\BcDelngFeeDtls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BcMngr extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'bc_mngr';

    protected $primaryKey = 'mngr_id';

    public $timestamps = false;

    protected $guarded = [

    ];

    protected $hidden = [
        'password',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function bcMngrCrtfc()
    {
        return $this->hasMany( BcMngrCrtfc::class, 'mngr_id' );
    }

    public function bcGrdComputStdr()
    {
        return $this->hasMany( BcGrdComputStdr::class, 'mngr_id' );
    }

    public function bcMber()
    {
        return $this->hasMany( BcMber::class, 'mngr_id' );
    }

    public function bcCaDelngDtls()
    {
        return $this->hasMany( BcCaDelngDtls::class, 'mngr_id' );
    }

    public function bcCaDelngDtlsChghst()
    {
        return $this->hasMany( BcCaDelngDtlsChghst::class, 'ca_delng_dtls_id' );
    }

    public function bcMberDelngDtls()
    {
        return $this->hasMany( BcMberDelngDtls::class, 'mngr_id' );
    }

    public function bcMberExchngDtls()
    {
        return $this->hasMany( BcMberExchngDtls::class, 'mngr_id' );
    }

    public function bcMberPymntDtls()
    {
        return $this->hasMany( BcMberPymntDtls::class, 'mngr_id' );
    }

    public function bcMberRtrvlDtls()
    {
        return $this->hasMany( BcMberRtrvlDtls::class, 'mngr_id' );
    }

    public function bcDelngFeeDtls()
    {
        return $this->hasMany( BcDelngFeeDtls::class, 'mngr_id' );
    }

    public function bcCaStats()
    {
        return $this->hasMany( BcCaStats::class, 'mngr_id' );
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
            return $query->where($where, 'like', '%'.$keyword.'%');
        }
        if($where == 'code')
        {
            return $query->where($where, 'like', '%'.$keyword.'%');
        }
        if($where == 'mngr_sttus')
        {
            return $query->where('mngr_sttus', $keyword);
        }

        return $query->where($where, 'like', '%'.$keyword.'%');
    }
}
