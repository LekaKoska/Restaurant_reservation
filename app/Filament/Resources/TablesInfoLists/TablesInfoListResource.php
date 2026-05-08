<?php

namespace App\Filament\Resources\TablesInfoLists;

use App\Filament\Resources\TablesInfoLists\Pages\CreateTablesInfoList;
use App\Filament\Resources\TablesInfoLists\Pages\EditTablesInfoList;
use App\Filament\Resources\TablesInfoLists\Pages\ListTablesInfoLists;
use App\Filament\Resources\TablesInfoLists\Schemas\TablesInfoListForm;
use App\Filament\Resources\TablesInfoLists\Tables\TablesInfoListsTable;
use App\Models\TablesInfoListModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TablesInfoListResource extends Resource
{
    protected static ?string $model = TablesInfoListModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Tables list';

    public static function form(Schema $schema): Schema
    {
        return TablesInfoListForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TablesInfoListsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTablesInfoLists::route('/'),
            'create' => CreateTablesInfoList::route('/create'),
            'edit' => EditTablesInfoList::route('/{record}/edit'),
        ];
    }
}
