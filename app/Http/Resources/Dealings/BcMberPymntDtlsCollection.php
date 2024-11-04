<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BcMberPymntDtlsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return BcMberPymntDtlsResource::collection($this->collection);
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
 *      schema="BcMberPymntDtlsCollection",
 *      type="array",
 *      @OA\Items(
 *          ref="#/components/schemas/BcMberPymntDtlsResource",
 *      )
 * )
 */
