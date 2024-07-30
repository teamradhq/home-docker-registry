<?php

namespace App\Filament\Resources\Docker\RepositoryResource\Pages;

use App\Filament\Resources\Docker\RepositoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepositories extends ListRecords
{
    protected static string $resource = RepositoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
