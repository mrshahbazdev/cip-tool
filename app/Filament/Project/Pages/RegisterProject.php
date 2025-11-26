<?php

namespace App\Filament\Project\Pages;

use App\Models\Project;
use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterProject extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Start free trial';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Workspace')
                ->description('Create a workspace for your company or team.')
                ->schema([
                    TextInput::make('project_name')
                        ->label('Workspace name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('slug')
                        ->label('Subdomain')
                        ->helperText('This becomes your link, for example work.cip-tools.de')
                        ->required()
                        ->alphaDash()
                        ->maxLength(50)
                        ->live(onBlur: true)
                        ->unique(Project::class, 'slug'),
                ])
                ->columns(2),

            Section::make('Your account')
                ->description('This will be the admin user for this workspace.')
                ->schema([
                    TextInput::make('name')
                        ->label('Your name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Work email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(User::class, 'email'),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required()
                        ->rule(Password::defaults())
                        ->same('password_confirmation'),

                    TextInput::make('password_confirmation')
                        ->label('Confirm password')
                        ->password()
                        ->required(),
                ])
                ->columns(2),

            Checkbox::make('accept_terms')
                ->label('I agree to the terms and privacy policy')
                ->required(),
        ]);
    }

    protected function handleRegistration(array $data): Project
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $project = Project::create([
            'name'      => $data['project_name'],
            'slug'      => $data['slug'],
            'owner_id'  => $user->id,
            'is_active' => true,
        ]);

        $project->members()->attach($user->id, ['role' => 'project_admin']);

        auth()->login($user);

        Notification::make()
            ->title('Workspace created')
            ->success()
            ->send();

        return $project;
    }
}
