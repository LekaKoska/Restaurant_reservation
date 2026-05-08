<?php

namespace App\Filament\Resources\TablesInfoLists\Pages;

use App\Filament\Resources\TablesInfoLists\TablesInfoListResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTablesInfoLists extends ListRecords
{
    protected static string $resource = TablesInfoListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
