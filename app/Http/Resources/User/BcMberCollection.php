<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcMberCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcMberResource::collection($this->collection);
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
 *      schema="BcMberCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcMberResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminMembersGet_BcMberCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/MemberAdminMembersGet_BcMberResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminMemberSubscribesGet_BcMberCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/MemberAdminMemberSubscribesGet_BcMberResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberMembersGet_BcMberCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/MemberMembersGet_BcMberResource",
 *      )
 * )
 */
