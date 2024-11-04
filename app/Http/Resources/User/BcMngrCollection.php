<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcMngrCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcMngrResource::collection($this->collection);
    }

    public function toResponse($request)
    {
        return JsonResource::toResponse($request);
    }

    public function with($request)
    {
        return [
            'status'    => true,
            'message'   => 'success',
            'pagination'        => [
                'total'         => $this->total(),
                'count'         => $this->count(),
                'per_page'      => $this->perPage(),
                'current_page'  => $this->currentPage(),
                'total_pages'   => $this->lastPage()
            ],
        ];
    }
}

/**
 * @OA\Schema(
 *      schema="BcMngrCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcMngrResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminManagersGet_BcMngrCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/MemberAdminManagersGet_BcMngrResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminMemberGradesGet_BcMngrCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/MemberAdminMemberGradesGet_BcMngrResource",
 *      )
 * )
 */
