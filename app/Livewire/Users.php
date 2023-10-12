<?php

namespace App\Livewire;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;

class Users extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public function createUserAction(): Action
    {
        return Action::make('CreateUser')
            ->form([
                TextInput::make('name')
                    ->label('Name')
                    ->rules(['required', 'string']),
                TextInput::make('email')
                    ->label('Email')
                    ->rules(['required', 'string', 'email'])
                    ->unique('users', 'email'),
            ])
            ->action(function (array $data): void {
                User::create($data);
            })->visible(auth()->guard('admin')->user()->can('create'));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('email')->sortable()->searchable(isIndividual: true),
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
                            ->label('Name')
                            ->rules(['required', 'string']),
                        TextInput::make('email')
                            ->label('Email')
                            ->rules(['required', 'string', 'email'])
                            ->unique('users', 'email', ignoreRecord: true),
                    ])->visible(fn (User $user) => auth()->guard('admin')->user()->can('update', $user)),
                ViewAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Name'),
                        TextInput::make('email')
                            ->label('Email'),
                    ]),
                DeleteAction::make()->visible(fn (User $user) => auth()->guard('admin')->user()->can('delete', $user))
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn (User $user) => auth()->guard('admin')->user()->can('delete', $user)),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.users');
    }
}
