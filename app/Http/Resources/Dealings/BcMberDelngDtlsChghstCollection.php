<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcMberDelngDtlsChghstCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcMberDelngDtlsChghstResource::collection($this->collection);
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
 *      schema="BcMberDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcMberDelngDtlsChghstResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminPurchaseMemberHistoryGet_BcMberDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminPurchaseMemberHistoryGet_BcMberDelngDtlsChghstResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSaleMemberHistoryGet_BcMberDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminSaleMemberHistoryGet_BcMberDelngDtlsChghstResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsAdminMemberDetailHistoryGet_BcMberDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/DealingsAdminMemberDetailHistoryGet_BcMberDelngDtlsChghstResource",
 *      )
 * )
 */
