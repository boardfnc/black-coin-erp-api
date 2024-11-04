<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcCaDelngDtlsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcCaDelngDtlsResource::collection($this->collection);
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
 *      schema="BcCaDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcCaDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminPurchaseManagersGet_BcCaDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminPurchaseManagersGet_BcCaDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSaleManagersGet_BcCaDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminSaleManagersGet_BcCaDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsAdminManagerDetailsGet_BcCaDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/DealingsAdminManagerDetailsGet_BcCaDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsManagerDetailsGet_BcCaDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/DealingsManagerDetailsGet_BcCaDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinPurchaseManagersGet_BcCaDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinPurchaseManagersGet_BcCaDelngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinSaleManagersGet_BcCaDelngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinSaleManagersGet_BcCaDelngDtlsResource",
 *      )
 * )
 */
