<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class PermissionCRUD extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public function createPermissionAction(): Action
    {
        return Action::make('CreatePermission')
            ->form([
                TextInput::make('name')
                    ->label('Menu Name')
                    ->rules(['required', 'string', 'unique:permissions,name']),
                TextInput::make('route_name')
                    ->label('Menu Route Name')
                    ->rules(['required', 'string', 'unique:permissions,route_name', function () {
                        return function (string $attribute, $value, Closure $fail) {
                            if (!Route::has($value)) {
                                $fail('The :attribute is not a valid route name in the application.');
                            }
                        };
                    },]),
            ])
            ->action(function (array $data): void {
                Permission::create($data);
            })->visible(auth()->guard('admin')->user()->can('create', Permission::class));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Permission::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('route_name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('table_name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('roles.name')->badge(),
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
                            ->label('Permission Name')
                            ->rules(['required', 'string'])
                            ->unique('permissions', 'name', ignoreRecord: true),
                        TextInput::make('route_name')
                            ->label('Menu Route Name')
                            ->rules(['required', 'string', function () {
                                return function (string $attribute, $value, Closure $fail) {
                                    if (!Route::has($value)) {
                                        $fail('The :attribute is not a valid route name in the application.');
                                    }
                                };
                            },])
                            ->unique('permissions', 'route_name', ignoreRecord: true),
                    ])->visible(fn (Permission $permission) => auth()->guard('admin')->user()->can('update', $permission)),
                DeleteAction::make()->visible(fn (Permission $permission) => auth()->guard('admin')->user()->can('delete', $permission)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn (Permission $permission) => auth()->guard('admin')->user()->can('delete', $permission)),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.permission-c-r-u-d');
    }
}
