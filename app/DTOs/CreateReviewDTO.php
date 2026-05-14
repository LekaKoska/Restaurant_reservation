<?php

namespace App\DTOs;
final readonly class CreateReviewDTO
{
    public function __construct(
        public int $reservationId,
        public int $rating,
        public string $comment
    ) {}

    public static function fromRequest($request): CreateReviewDTO
    {
        return new self(
            reservationId: $request->validated("reservation_id"),
            rating: $request->validated("rating"),
            comment: $request->validated("comment"),
        );
    }
    public function toArray(): array
    {
        return [
            "reservation_id" => $this->reservationId,
            "rating" => $this->rating,
            "comment" => $this->comment
        ];
    }
}
