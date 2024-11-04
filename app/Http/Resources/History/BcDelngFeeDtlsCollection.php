<?php

namespace App\Http\Resources\History;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcDelngFeeDtlsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcDelngFeeDtlsResource::collection($this->collection);
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
 *      schema="BcDelngFeeDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcDelngFeeDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminDealingsFeeDetailsGet_BcDelngFeeDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminDealingsFeeDetailsGet_BcDelngFeeDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinDealingsFeeDetailsGet_BcDelngFeeDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinDealingsFeeDetailsGet_BcDelngFeeDtlsResource",
 *      )
 * )
 */



