<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Role;
use Closure;
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
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Admins extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public $allRoles;

    public function mount()
    {
        $this->allRoles = Role::get(['id', 'name'])->toArray();
    }

    public function createAdminAction(): Action
    {
        return Action::make('CreateAdmin')
            ->form([
                TextInput::make('name')
                    ->label('Name')
                    ->rules(['required', 'string']),
                TextInput::make('email')
                    ->label('Email')
                    ->rules(['required', 'string', 'email']),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
                Select::make('role_id')
                    ->label('Admin Role')
                    ->options(getSelectDropDownFormatForFilament($this->allRoles))
                    ->rules(['required', 'integer']),
            ])
            ->action(function (array $data): void {
                Admin::create($data);
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Admin::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('email')->sortable()->searchable(isIndividual: true),
                TextColumn::make('role.name')->badge()->sortable()->searchable(isIndividual: true),
                TextColumn::make('created_at')->label('Created At')->sortable()->since(),
                TextColumn::make('updated_at')->sortable()->dateTime(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Name')
                            ->rules(['required', 'string']),
                        TextInput::make('email')
                            ->label('Email')
                            ->rules(['required', 'string', 'email'])
                            ->unique('admins', 'email', ignoreRecord: true),
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
                        Select::make('role_id')
                            ->label('Admin Role')
                            ->options(getSelectDropDownFormatForFilament($this->allRoles))
                            ->rules(['required', 'integer']),
                    ]),
                ViewAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Name'),
                        TextInput::make('email')
                            ->label('Email'),
                        Select::make('role_id')
                            ->label('Admin Role')
                            ->options(getSelectDropDownFormatForFilament($this->allRoles)),
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
        return view('livewire.admins');
    }
}
