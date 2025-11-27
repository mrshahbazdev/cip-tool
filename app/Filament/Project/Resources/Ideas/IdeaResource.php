<?php

namespace App\Filament\Project\Resources\Ideas;

use App\Filament\Project\Resources\Ideas\Pages\CreateIdea;
use App\Filament\Project\Resources\Ideas\Pages\EditIdea;
use App\Filament\Project\Resources\Ideas\Pages\ListIdeas;
use App\Filament\Project\Resources\Ideas\Schemas\IdeaForm;
use App\Filament\Project\Resources\Ideas\Tables\IdeasTable;
use App\Models\Idea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
class IdeaResource extends Resource
{
    protected static ?string $model = Idea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return IdeaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Idea')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('team_name')
                    ->label('Team')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'in_review',
                        'success' => 'done',
                    ])
                    ->sortable(),

                TextColumn::make('pain_score')
                    ->label('Pain')
                    ->sortable(),

                TextColumn::make('cost')
                    ->money('eur') // ya jo bhi currency
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Days')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->label('Created')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_review' => 'In review',
                        'done' => 'Done',
                    ]),
                Tables\Filters\SelectFilter::make('team_name')
                    ->label('Team')
                    ->options(
                        fn () => \App\Models\Idea::query()
                            ->distinct()
                            ->pluck('team_name', 'team_name')
                            ->filter()
                            ->toArray()
                    ),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => ListIdeas::route('/'),
            'create' => CreateIdea::route('/create'),
            'edit' => EditIdea::route('/{record}/edit'),
        ];
    }
}
