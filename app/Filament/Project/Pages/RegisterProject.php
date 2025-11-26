<?php

namespace App\Filament\Project\Pages;

use App\Models\Project;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterProject extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Start free trial';
    }

    // Yahan koi type-hint nahi (na parameter pe, na return pe)
    public function form($schema)
    {
        return $schema->schema([
            Forms\Components\Section::make('Workspace')
                ->description('Create a workspace for your company or team.')
                ->schema([
                    Forms\Components\TextInput::make('project_name')
                        ->label('Workspace name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('slug')
                        ->label('Subdomain')
                        ->helperText('This becomes your link, for example work.cip-tools.de')
                        ->required()
                        ->alphaDash()
                        ->maxLength(50)
                        ->live(onBlur: true)
                        ->unique(Project::class, 'slug'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Your account')
                ->description('This will be the admin user for this workspace.')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Your name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('Work email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(User::class, 'email'),

                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->required()
                        ->rule(Password::defaults())
                        ->same('password_confirmation'),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Confirm password')
                        ->password()
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Checkbox::make('accept_terms')
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
