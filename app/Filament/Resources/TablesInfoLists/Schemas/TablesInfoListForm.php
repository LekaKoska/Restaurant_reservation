<?php

namespace App\Filament\Resources\TablesInfoLists\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TablesInfoListForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("table_num")
                    ->required()
                    ->numeric(),
                TextInput::make("location")
            ]);
    }
}
