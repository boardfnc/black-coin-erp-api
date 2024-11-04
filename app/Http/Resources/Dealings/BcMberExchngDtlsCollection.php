<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcMberExchngDtlsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcMberExchngDtlsResource::collection($this->collection);
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
 *      schema="BcMberExchngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcMberExchngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminReceivedDetailsGet_BcMberExchngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminReceivedDetailsGet_BcMberExchngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSentDetailsGet_BcMberExchngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinAdminSentDetailsGet_BcMberExchngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinReceivedDetailsGet_BcMberExchngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinReceivedDetailsGet_BcMberExchngDtlsResource",
 *      )
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinSentDetailsGet_BcMberExchngDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/CoinSentDetailsGet_BcMberExchngDtlsResource",
 *      )
 * )
 */
