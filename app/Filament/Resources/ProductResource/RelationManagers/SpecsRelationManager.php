<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SpecsRelationManager extends RelationManager
{
    protected static string $relationship = 'specs';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('key')->required(),
            TextInput::make('value')->required(),
            TextInput::make('value_numeric')->numeric()->nullable(),
            TextInput::make('unit'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key'),
                TextColumn::make('value'),
                TextColumn::make('value_numeric'),
                TextColumn::make('unit'),
            ])
            ->headerActions([CreateAction::make()])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->reorderable('sort_order');
    }
}
