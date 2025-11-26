<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            // Pivot role field
            TextInput::make('pivot.role')
                ->label('Role')
                ->default('member')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('User')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('pivot.role')
                    ->label('Role')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Naye member attach karne ke liye
                AttachAction::make()
                    ->label('Attach User')
                    ->form(fn (Schema $schema) => $schema->schema([
                        Select::make('recordId')
                            ->label('User')
                            ->relationship('members', 'name')
                            ->searchable()
                            ->required(),
                        TextInput::make('role')
                            ->label('Role')
                            ->default('member')
                            ->required(),
                    ])),
            ])
            ->recordActions([
                // Pivot role edit + detach
                \Filament\Actions\EditAction::make()
                    ->label('Edit Role'),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
