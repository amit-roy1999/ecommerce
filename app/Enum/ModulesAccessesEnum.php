<?php

namespace App\Enum;

enum ModulesAccessesEnum: int
{
    case All = 0;
    case Create = 1;
    case Update = 2;
    case Delete = 3;

    static function returnAllCaseJson() : string{
        $return = [];
        foreach (ModulesAccessesEnum::cases() as $value) {
            $return[] = [$value->name => $value->value];
        }
        return json_encode($return);
    }

    static function returnAllCaseforDropdown() : array{
        $return = [];
        foreach (ModulesAccessesEnum::cases() as $value) {
            $return[] = [$value->value => $value->name];
        }
        return collect($return)->flatten()->toArray();
    }
}
