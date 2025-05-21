<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MainContentResource\Pages;
use App\Filament\Resources\MainContentResource\RelationManagers;
use App\Models\MainContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MainContentResource extends Resource
{
    protected static ?string $model = MainContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('start_video_link')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\Textarea::make('mission_description')
                    ->required()
                    ->columnSpan(2),
                Forms\Components\FileUpload::make('mission_image')
                    ->image()
                    ->required()
                    ->columnSpan(2),
                Forms\Components\Textarea::make('plan_description')
                    ->required()
                    ->columnSpan(2),
                Forms\Components\FileUpload::make('plan_image')
                    ->image()
                    ->required()
                    ->columnSpan(2),
                Forms\Components\Textarea::make('vision_description')
                    ->required()
                    ->columnSpan(2),
                Forms\Components\FileUpload::make('vision_image')
                    ->image()
                    ->required()
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_video_link')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('mission_image'),
                Tables\Columns\ImageColumn::make('plan_image'),
                Tables\Columns\ImageColumn::make('vision_image'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMainContents::route('/'),
            'create' => Pages\CreateMainContent::route('/create'),
            'edit' => Pages\EditMainContent::route('/{record}/edit'),
        ];
    }
}
