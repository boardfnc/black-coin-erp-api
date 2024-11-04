<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcMberDelngDtlsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcMberDelngDtlsResource::collection($this->collection);
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
 *      schema="BcMberDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcMberDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminPurchaseMembersGet_BcMberDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminPurchaseMembersGet_BcMberDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSaleMembersGet_BcMberDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminSaleMembersGet_BcMberDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsAdminMemberDetailsGet_BcMberDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/DealingsAdminMemberDetailsGet_BcMberDelngDtlsResource",
 *      )
 * )
 */
