<?php

use Illuminate\Support\Facades\Storage;

function getSelectDropDownFormatForFilament(array $val): array
{
    $returnVal = [];
    foreach ($val as $value) {
        $returnVal[$value['id']] = $value['name'];
    }
    return $returnVal;
}
function deleteImageIfExists(string $disk, string | null $imagePath): bool
{
    if ($imagePath != null) {
        return Storage::disk($disk)->exists($imagePath) ? Storage::disk($disk)->delete($imagePath) : false;
    }
    return false;
}
function s(): bool
{
    return false;
}
