<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcAcnutSetup extends Model
{
    use HasFactory;

    protected $table = 'bc_acnut_setup';

    protected $primaryKey = 'acnut_setup_id';

    protected $guarded = [

    ];
}
