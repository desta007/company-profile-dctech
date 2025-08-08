<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Filament\Resources\PortfolioResource\RelationManagers;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category')
                    ->options([
                        'web' => 'Web',
                        'mobile' => 'Mobile',
                        'design' => 'Design',
                        'course' => 'Course Online',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('client_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('project_date')
                    ->required(),
                Forms\Components\TextInput::make('project_url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('detail_title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('detail_description')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('portfolioDetail')
                    ->relationship('portfolioDetails')
                    ->label('Portfolio Details')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options([
                                'image' => 'Image',
                                'video' => 'Video',
                            ])
                            ->required()
                            ->reactive(),

                        Forms\Components\FileUpload::make('image_file')
                            ->label('Image File')
                            ->directory('portfolio_details')
                            ->image()
                            ->visibility('public')
                            ->required(fn(callable $get) => $get('type') === 'image')
                            ->visible(fn(callable $get) => $get('type') === 'image'),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->placeholder('https://youtube.com/... atau https://vimeo.com/...')
                            ->required(fn(callable $get) => $get('type') === 'video')
                            ->visible(fn(callable $get) => $get('type') === 'video'),
                    ])
                    ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
                        // mapping dari DB ke field form
                        if (($data['type'] ?? '') === 'image') {
                            $data['image_file'] = $data['file'] ?? null;
                        } elseif (($data['type'] ?? '') === 'video') {
                            $data['video_url'] = $data['file'] ?? null;
                        }
                        return $data;
                    })
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                        if ($data['type'] === 'image') {
                            $data['file'] = $data['image_file'] ?? '';
                        } elseif ($data['type'] === 'video') {
                            $data['file'] = $data['video_url'] ?? '';
                        }
                        unset($data['image_file'], $data['video_url']);
                        return $data;
                    })
                    ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                        if ($data['type'] === 'image') {
                            $data['file'] = $data['image_file'] ?? '';
                        } elseif ($data['type'] === 'video') {
                            $data['file'] = $data['video_url'] ?? '';
                        }
                        unset($data['image_file'], $data['video_url']);
                        return $data;
                    })
                    ->minItems(1)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
