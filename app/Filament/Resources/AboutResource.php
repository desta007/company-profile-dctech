<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hugomyb\FilamentMediaAction\Forms\Components\Actions\MediaAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->placeholder('Description')
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\TextInput::make('video_link')
                    ->required(),
                Forms\Components\TextInput::make('count_client')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('count_project')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('count_year_of_experience')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('count_award')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('video_link'),
                Tables\Columns\TextColumn::make('count_client'),
                Tables\Columns\TextColumn::make('count_project'),
                Tables\Columns\TextColumn::make('count_year_of_experience'),
                Tables\Columns\TextColumn::make('count_award'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
