<?php

namespace App\Filament\Resources\TablesInfoLists\Pages;

use App\Filament\Resources\TablesInfoLists\TablesInfoListResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTablesInfoList extends EditRecord
{
    protected static string $resource = TablesInfoListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
