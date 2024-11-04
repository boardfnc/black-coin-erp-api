<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcCaDelngDtlsChghstCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcCaDelngDtlsChghstResource::collection($this->collection);
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
 *      schema="BcCaDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcCaDelngDtlsChghstResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminPurchaseManagerHistoryGet_BcCaDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminPurchaseManagerHistoryGet_BcCaDelngDtlsChghstResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSaleManagerHistoryGet_BcCaDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminSaleManagerHistoryGet_BcCaDelngDtlsChghstResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsAdminManagerDetailHistoryGet_BcCaDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/DealingsAdminManagerDetailHistoryGet_BcCaDelngDtlsChghstResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsManagerDetailHistoryGet_BcCaDelngDtlsChghstCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/DealingsManagerDetailHistoryGet_BcCaDelngDtlsChghstResource",
 *      )
 * )
 */
