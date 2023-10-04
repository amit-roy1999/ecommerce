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
use Filament\Forms\Set;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
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
        $this->allPermissions = getSelectDropDownFormatForFilament(Permission::get(['id', 'name'])->toArray());
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
                ActionGroup::make([
                    ActionsAction::make('Permissions')
                        ->form([
                            Select::make('permission')
                                ->options($this->allPermissions)
                                ->live()
                                ->afterStateUpdated(function (Set $set, ?string $state, Role $role) {
                                    $val = $role->permissions()->wherePivot('permission_id', $state)->first()?->toArray()['pivot']['accesses'];
                                    if ($val !== null) {
                                        $set('accesses', json_decode($val));
                                    }
                                })->rules(['required', 'string']),
                            Select::make('accesses')
                                ->multiple()
                                ->options(ModulesAccessesEnum::returnAllCaseforDropdown())
                                ->rules(['required', 'array'])
                        ])
                        ->action(function (Role $role, $data): void {
                            $role->permissions()->syncWithoutDetaching([$data['permission'] => ['accesses' => json_encode($data['accesses'])]]);
                        }),
                    ActionsAction::make('deletePermissions')
                        ->form([
                            Select::make('permission')
                                ->options(fn (Role $role) => getSelectDropDownFormatForFilament($role->permissions()->get(['id', 'name'])))
                                ->rules(['required', 'string']),
                        ])
                        ->requiresConfirmation()
                        ->action(function (Role $role, $data): void {
                            $role->permissions()->detach($data['permission']);
                        }),

                    EditAction::make('edit')
                        ->form([
                            TextInput::make('name')
                                ->label('Role Name')
                                ->rules(['required', 'string'])
                                ->unique('roles','name',ignoreRecord: true),
                        ]),
                    ViewAction::make()
                        ->form([
                            TextInput::make('name')
                                ->label('Role Name')
                                ->rules(['required', 'string', 'unique:roles,name']),
                        ]),
                    DeleteAction::make()
                ])

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
