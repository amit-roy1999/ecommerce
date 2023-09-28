<?php

namespace App\Livewire;

use App\Models\Role;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;

class RoleCRUD extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public function createRoleAction(): Action
    {
        return Action::make('CreateRole')
            ->form([
                TextInput::make('name')
                    ->label('Role Name')
                    ->rules(['required', 'string', 'unique:roles,name']),
            ])
            ->action(function (array $data): void {
                Role::create($data);
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Role::query())
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.role-c-r-u-d');
    }
}
