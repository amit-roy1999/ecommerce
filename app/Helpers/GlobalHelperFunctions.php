<?php

function getSelectDropDownFormatForFilament(array $val): array
{
    $returnVal = [];
    foreach ($val as $value) {
        $returnVal[$value['id']] = $value['name'];
    }
    return $returnVal;
}

function doesUserHavePermissionForThisAction(): bool
{
    return false;
}
