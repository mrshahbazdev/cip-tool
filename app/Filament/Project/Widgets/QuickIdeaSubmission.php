<?php

namespace App\Filament\Project\Widgets;

use App\Models\Idea;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class QuickIdeaSubmission extends Widget implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    // Yahan "static" hata do
    protected string $view = 'filament.project.widgets.quick-idea-submission';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $host = request()->getHost();
        $slug = explode('.', $host)[0] ?? null;

        $project = Project::where('slug', $slug)->firstOrFail();

        $data = $this->form->getState();

        Idea::create([
            'project_id'   => $project->id,
            'title'        => $data['title'],
            'description'  => $data['description'],
            'team_name'    => $data['team_name'],
            'pain_score'   => $data['pain_score'],
            'cost'         => $data['cost'],
            'duration'     => $data['duration'],
            'status'       => 'new',
            'created_by'   => auth()->id(),
        ]);

        $this->form->fill();

        Notification::make()
            ->title('Idea submitted')
            ->body('Your idea has been added to the pipeline.')
            ->success()
            ->send();
    }

    protected function getFormModel(): string
    {
        return Idea::class;
    }
}
