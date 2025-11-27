<?php

namespace App\Filament\Project\Resources\Ideas\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class IdeaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('title')
                ->label('Idea title')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->rows(4)
                ->required(),

            Forms\Components\TextInput::make('team_name')
                ->label('Team / Department')
                ->required(),

            Forms\Components\TextInput::make('pain_score')
                ->label('Pain score')
                ->numeric()
                ->minValue(1)
                ->maxValue(10)
                ->required(),

            Forms\Components\TextInput::make('cost')
                ->label('Estimated cost')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('duration')
                ->label('Duration (days)')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('status')
                ->options([
                    'new' => 'New',
                    'in_review' => 'In review',
                    'done' => 'Done',
                ])
                ->required()
                ->default('new'),
        ]);
    }
}
