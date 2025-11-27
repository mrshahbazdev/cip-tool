<?php

namespace App\Filament\Project\Widgets;

use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class QuickIdeaSubmission extends Widget implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected string $view = 'filament.project.widgets.quick-idea-submission';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->label('Idea title')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('Short description')
                ->rows(3)
                ->required(),

            Forms\Components\TextInput::make('team_name')
                ->label('Team / Department')
                ->placeholder('e.g. Sales, IT, R&D')
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
        ];
    }

    protected function getFormModel(): string
    {
        return \stdClass::class;
    }

    protected function getFormStatePath(): ?string
    {
        return 'data';
    }

    public function submit(): void
    {
        // Sirf validation + reset, DB me kuch mat save karo

        $this->validate(); // form rules already fields pe lagi hui hain

        $this->form->fill();

        Notification::make()
            ->title('Idea submitted')
            ->body('Your idea has been captured. (Storage not wired yet.)')
            ->success()
            ->send();
    }

}
