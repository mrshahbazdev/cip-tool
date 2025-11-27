<?php

namespace App\Filament\Project\Resources;

use App\Filament\Project\Resources\TeamResource\Pages;
use App\Models\Team;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Schema;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;
    protected static ?string $tenantOwnershipRelationshipName = 'project';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Teams';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->limit(60),

                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Owner')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                // Default edit action (sirf owners ke liye policy se restrict kar sakte ho)
                Tables\Actions\EditAction::make(),

                // Join / Leave action
                Action::make('toggleMembership')
                    ->label(fn (Team $record) => $record->users()->where('user_id', auth()->id())->exists()
                        ? 'Leave team'
                        : 'Join team'
                    )
                    ->icon(fn (Team $record) => $record->users()->where('user_id', auth()->id())->exists()
                        ? 'heroicon-o-user-minus'
                        : 'heroicon-o-user-plus'
                    )
                    ->requiresConfirmation()
                    ->action(function (Team $record) {
                        $user = auth()->user();

                        if (! $user) {
                            return;
                        }

                        $isMember = $record->users()
                            ->where('user_id', $user->id)
                            ->exists();

                        if ($isMember) {
                            // Leave team
                            $record->users()->detach($user->id);
                        } else {
                            // Join team as member
                            $record->users()->attach($user->id, ['role' => 'member']);
                        }
                    }),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        // Sirf current tenant (project) ke teams
        return parent::getEloquentQuery()
            ->where('project_id', tenant()->id ?? null);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Teams\Pages\ListTeams::route('/'),
            'create' => Teams\Pages\CreateTeam::route('/create'),
            'edit'   => Teams\Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
