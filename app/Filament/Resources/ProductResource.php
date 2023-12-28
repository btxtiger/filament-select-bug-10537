<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),


                // You can not use both select at the same time

                Forms\Components\Select::make('category_id')
                    ->label('Works Not')
                    ->relationship(name: 'category')
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return "<span class='text-primary-600 dark:text-primary-400'>[{$record->id}]</span> {$record->name}";
                    })
                    ->native(false)
                    ->preload()
                    ->searchable(true)
                    ->allowHtml(true),

//                Forms\Components\Select::make('category_id')
//                    ->label('Works')
//                    ->relationship(name: 'category')
//                    ->getOptionLabelFromRecordUsing(function (Model $record) {
//                        return "[{$record->id}] {$record->name}";
//                    })
//                    ->native(false)
//                    ->preload()
//                    ->searchable(true)
//                    ->allowHtml(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }
}
