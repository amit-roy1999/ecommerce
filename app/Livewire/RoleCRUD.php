<?php

namespace App\Livewire;

use App\Models\Role;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
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
                // Select::make('permissions')
                //     ->multiple()
                //     ->options([
                //         'tailwind' => 'Tailwind CSS',
                //         'alpine' => 'Alpine.js',
                //         'laravel' => 'Laravel',
                //         'livewire' => 'Laravel Livewire',
                //     ])
            ])
            ->action(function (array $data): void {
                // dd($data);
                Role::create($data);
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Role::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('permissions.name')->badge(),
                TextColumn::make('created_at')->label('Created At')->sortable()->since(),
                TextColumn::make('updated_at')->sortable()->dateTime(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make('edit')
                    ->form([
                        TextInput::make('name')
                            ->label('Role Name')
                            ->rules(['required', 'string', 'unique:roles,name']),
                    ]),
                DeleteAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.role-c-r-u-d');
    }
}
