<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    // yahan type sahi rakho:
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Projects';

    protected static ?string $modelLabel = 'Project';

    protected static ?string $pluralModelLabel = 'Projects';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Section::make('Project Info')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('name')
                        ->label('Project Name')
                        ->required()
                        ->maxLength(255),

                    \Filament\Forms\Components\TextInput::make('slug')
                        ->label('Subdomain Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Ye hi subdomain hoga, jaise: company.cip-tools.com'),

                    \Filament\Forms\Components\Select::make('owner_id')
                        ->label('Owner (Super Admin)')
                        ->relationship('owner', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    \Filament\Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(false),

                    \Filament\Forms\Components\DateTimePicker::make('trial_ends_at')
                        ->label('Trial Ends At')
                        ->seconds(false)
                        ->native(false),
                ])
                ->columns(2),

            \Filament\Schemas\Section::make('Branding & Bonus')
                ->schema([
                    \Filament\Forms\Components\FileUpload::make('logo_path')
                        ->label('Logo')
                        ->image()
                        ->directory('projects/logos')
                        ->imageEditor()
                        ->nullable(),

                    \Filament\Forms\Components\TextInput::make('slogan')
                        ->label('Slogan / Motto')
                        ->maxLength(255)
                        ->placeholder('Thought together and made together'),

                    \Filament\Forms\Components\Toggle::make('bonus_enabled')
                        ->label('Bonus Enabled')
                        ->default(false),

                    \Filament\Forms\Components\Textarea::make('bonus_text')
                        ->label('Bonus / Remuneration Info')
                        ->rows(3)
                        ->helperText('Note: Bonus Cip-Tools.com nahi deta, project owner deta hai.'),
                ])
                ->columns(2),
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
                Tables\Actions\ViewAction::make(),
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
            'index'  => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit'   => EditProject::route('/{record}/edit'),
        ];
    }
}
