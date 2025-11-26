<?php

namespace App\Filament\Project\Pages;

use App\Models\Project;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
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

    public function form(Form $form): Form
    {
        return $form->schema([
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
                        ->live(onBlur: true) // real-time-ish check [web:319]
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
        // Owner user create karo
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'is_admin'  => true, // ya jo bhi flag tum use kar rahe ho
        ]);

        // Project create karo
        $project = Project::create([
            'name'          => $data['project_name'],
            'slug'          => $data['slug'],
            'owner_id'      => $user->id,
            'bonus_enabled' => false,
            'is_active'     => true,
        ]);

        // Owner ko member attach karo
        $project->members()->attach($user->id, ['role' => 'project_admin']);

        // Optionally user ko auto login karao
        auth()->login($user);

        Notification::make()
            ->title('Workspace created')
            ->body('Your trial workspace is ready. You can now invite your team.')
            ->success()
            ->send();

        return $project;
    }
}
