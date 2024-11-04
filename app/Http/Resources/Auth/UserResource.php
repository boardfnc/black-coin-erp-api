<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $bc_mngr = array();
        $bc_mngr['mngr_id'] = $this->mngr_id;
        $bc_mngr['mngr_se'] = $this->mngr_se;
        $bc_mngr['mngr_sttus'] = $this->mngr_sttus;
        $bc_mngr['login_id'] = $this->login_id;

        $r = $bc_mngr;

        return $r;
    }
}
