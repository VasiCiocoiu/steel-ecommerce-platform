<?php

namespace App\Enum;

enum TypeItemManager: string
{
    case Cart = 'Cart';
    case Purchase = 'Purchase';
    case Quote = 'Quote';
    case Wishlist = 'Wishlist';

    public static function toArray(): array
    {
        return [
            self::Cart,
            self::Purchase,
            self::Quote,
            self::Wishlist
        ];
    }

    public static function fromValue(string $value): string
    {
        foreach (self::toArray() as $item) {
            if ($item === $value) {
                return $item;
            }
        }

        throw new \InvalidArgumentException("Invalid value: $value");
    }
}
