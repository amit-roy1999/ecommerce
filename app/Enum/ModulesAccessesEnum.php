<?php

namespace App\Enum;

enum ModulesAccessesEnum: string
{
    case Create = "1";
    case Update = "2";
    case Delete = "3";

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
            $return[$value->value] = $value->name;
        }
        return $return;
    }
}
