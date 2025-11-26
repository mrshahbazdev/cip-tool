<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use App\Models\User;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Projects';

    protected static ?string $modelLabel = 'Project';

    protected static ?string $pluralModelLabel = 'Projects';

    protected static ?string $recordTitleAttribute = 'name';

    // IMPORTANT: yahan Schema use hoga, Form nahi
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('Project Name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('slug')
                ->label('Subdomain Slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Ye hi subdomain hoga, jaise: company.cip-tools.com'),

            Forms\Components\Select::make('owner_id')
                ->label('Owner (Super Admin)')
                ->options(User::pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(false),

            Forms\Components\DateTimePicker::make('trial_ends_at')
                ->label('Trial Ends At')
                ->seconds(false)
                ->native(false),

            Forms\Components\FileUpload::make('logo_path')
                ->label('Logo')
                ->image()
                ->directory('projects/logos')
                ->imageEditor()
                ->nullable(),

            Forms\Components\TextInput::make('slogan')
                ->label('Slogan / Motto')
                ->maxLength(255)
                ->placeholder('Thought together and made together'),

            Forms\Components\Toggle::make('bonus_enabled')
                ->label('Bonus Enabled')
                ->default(false),

            Forms\Components\Textarea::make('bonus_text')
                ->label('Bonus / Remuneration Info')
                ->rows(3)
                ->helperText('Note: Bonus Cip-Tools.com nahi deta, project owner deta hai.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Subdomain')
                    ->searchable(),

                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Owner')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('trial_ends_at')
                    ->label('Trial Ends')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                // custom actions abhi blank rakho
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit'   => EditProject::route('/{record}/edit'),
        ];
    }
}
