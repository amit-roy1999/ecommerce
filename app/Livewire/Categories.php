<?php

namespace App\Livewire;

use App\Models\Category;
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
use Filament\Forms\Set;
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

class Categories extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public function createCategoryAction(): Action
    {
        return Action::make('CreateCategory')
            ->form([
                TextInput::make('name')
                    ->label('Name')
                    ->live(false, 500)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        if ($state !== null) {
                            $set('slug', (string)str($state)->slug());
                        }
                    })
                    ->rules(['required', 'string', 'unique:categories,name']),
                TextInput::make('slug')
                    ->label('Slug')
                    ->rules(['required', 'string', 'unique:categories,slug']),

            ])
            ->action(function (array $data): void {
                Category::create($data);
            })->visible(auth()->guard('admin')->user()->can('create', User::class));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Category::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('slug')->sortable()->searchable(isIndividual: true),
                TextColumn::make('childCategories.name')->badge(),
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
        return view('livewire.categories');
    }
}
