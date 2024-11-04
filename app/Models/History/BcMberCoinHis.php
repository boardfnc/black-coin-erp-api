<?php

namespace App\Models\History;

use App\Models\Dealings\BcMberDelngDtls;
use App\Models\Dealings\BcMberExchngDtls;
use App\Models\Dealings\BcMberPymntDtls;
use App\Models\Dealings\BcMberRtrvlDtls;
use App\Models\User\BcMber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcMberCoinHis extends Model
{
    use HasFactory;

    protected $table = 'bc_mber_coin_his';

    protected $primaryKey = 'mber_coin_his_id';

    protected $guarded = [

    ];

    const UPDATED_AT = null;

    public function bcMber()
    {
        return $this->belongsTo( BcMber::class, 'mber_id' );
    }

    public function bcMberDelngDtls()
    {
        return $this->belongsTo( BcMberDelngDtls::class, 'mber_delng_dtls_id' );
    }

    public function bcMberExchngDtls()
    {
        return $this->belongsTo( BcMberExchngDtls::class, 'mber_exchng_dtls_id' );
    }

    public function bcMberRtrvlDtls()
    {
        return $this->belongsTo( BcMberRtrvlDtls::class, 'mber_rirvl_dtls_id' );
    }

    public function bcMberPymntDtls()
    {
        return $this->belongsTo( BcMberPymntDtls::class, 'mber_pymnt_dtls_id' );
    }
}
