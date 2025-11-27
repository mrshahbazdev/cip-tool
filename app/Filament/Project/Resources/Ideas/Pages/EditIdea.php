<?php

namespace App\Filament\Project\Resources\Ideas\Pages;

use App\Filament\Project\Resources\Ideas\IdeaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIdea extends EditRecord
{
    protected static string $resource = IdeaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
