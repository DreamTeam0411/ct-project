<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Category\CategoryIdNameSlugResource;
use App\Http\Resources\City\CityIdNameAndSlugResource;
use App\Repositories\Services\Iterators\PrivateServiceIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class AdminServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'AdminService',
        description: 'Show information about service',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'integer',
            ),
            new OA\Property(
                property: 'category',
                ref: '#/components/schemas/CategoryIdNameSlug'
            ),
            new OA\Property(
                property: 'title',
                type: 'integer',
            ),
            new OA\Property(
                property: 'description',
                type: 'string',
            ),
            new OA\Property(
                property: 'photo',
                type: 'string',
            ),
            new OA\Property(
                property: 'user',
                ref: '#/components/schemas/User'
            ),
            new OA\Property(
                property: 'price',
                type: 'number',
                format: 'double'
            ),
            new OA\Property(
                property: 'city',
                ref: '#/components/schemas/CityIdNameAndSlug'
            ),
            new OA\Property(
                property: 'createdAt',
                type: 'integer',
            ),
            new OA\Property(
                property: 'updatedAt',
                type: 'integer',
            ),
        ],
        example: [
            'id' => 1,
            'category'  => [
                'id'    => 4,
                'title' => 'Догляд за нігтями',
                'slug'  => 'doglyad-za-nigtyami',
            ],
            'title'         => 'Заголовок послуги',
            'description'   => 'Детальний опис послуги',
            'photo'         => 'y1lzlmDXALGM0JIEQSSC2cu2fCb2ptJZZCmT8ihM.jpg',
            'user' => [
                'id' => 32,
                'firstName'     => 'Олена',
                'lastName'      => 'Новікова',
                'phoneNumber'   => '380978889944',
                'address'       => 'вул. Нова, 9',
                'link'          => 'https://www.instagram.com/lorem-ipsum',
                'email'         => 'olena.novikova@example.com'
            ],
            'price' => 900.45,
            'city' => [
                'id' => 1,
                'name' => 'Київ',
                'slug' => 'ukrayina-kiyiv',
            ],
            'createdAt' => '2023-12-02 14:51:18',
            'updatedAt' => '2023-12-02 14:51:18',
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var PrivateServiceIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'category'      => new CategoryIdNameSlugResource($resource->getCategory()),
            'title'         => $resource->getTitle(),
            'description'   => $resource->getDescription(),
            'photo'         => $resource->getPhoto() ?? '',
            'user'          => [
                'id'            => $resource->getUser()->getId(),
                'firstName'     => $resource->getUser()->getFirstName(),
                'lastName'      => $resource->getUser()->getLastName(),
                'phoneNumber'   => $resource->getUser()->getPhoneNumber(),
                'address'       => $resource->getUser()->getAddress() ?? '',
                'link'          => $resource->getUser()->getLink() ?? '',
                'email'         => $resource->getUser()->getEmail(),
            ],
            'price'         => $resource->getPrice(),
            'city'          => new CityIdNameAndSlugResource($resource->getCity()),
            'createdAt'     => $resource->getCreatedAt(),
            'updatedAt'     => $resource->getUpdatedAt(),
        ];
    }
}
