<?php

namespace App\Enum;

enum QuoteStatus: string
{
    case Pending_Employee = 'Pending_employee';
    case Pending_Client = 'Pending_client';
    case Canceled = 'Canceled';

    public static function toArray(): array
    {
        return [
            self::Pending_Employee,
            self::Pending_Client,
            self::Canceled,
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
