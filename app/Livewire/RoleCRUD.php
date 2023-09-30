<?php

namespace App\Livewire;

use App\Enum\ModulesAccessesEnum;
use App\Models\Permission;
use App\Models\Role;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action as ActionsAction;
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

    public array $allPermissions;

    public function mount()
    {
        $this->allPermissions = Permission::get(['id', 'name'])->map(fn ($item) => [$item->id => $item->name])->flatten()->toArray();
    }
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
                TextColumn::make('id')->rowIndex()->sortable(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('permissions.name')->badge(),
                TextColumn::make('created_at')->label('Created At')->sortable()->dateTime(),
                TextColumn::make('updated_at')->sortable()->since(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ActionsAction::make('addPermission')
                    ->form([
                        Select::make('permissions')
                            ->options($this->allPermissions),
                        Select::make('accesses')
                            ->multiple()
                            ->options(ModulesAccessesEnum::returnAllCaseforDropdown())
                    ])
                    ->action(function (Role $role, $data): void {
                        $role->permissions()->attach($data['permissions'], ['accesses' => json_encode($data['accesses'])]);
                    }),
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
