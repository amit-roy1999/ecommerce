<?php

namespace App\Livewire;

use App\Models\SpecificationName;
use App\Models\SpecificationUnit;
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

class SpecificationUnits extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public function createSpecificationUnitAction(): Action
    {
        return Action::make('CreateSpecificationUnit')
            ->form([
                TextInput::make('name')
                    ->label('Name')
                    ->live(false, 500)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        if ($state !== null) {
                            $set('slug', (string)str($state)->slug());
                        }
                    })
                    ->rules(['required', 'string', 'unique:specification_units,name']),
                TextInput::make('slug')
                    ->label('Slug')
                    ->rules(['required', 'string', 'unique:specification_units,slug']),
            ])
            ->action(function (array $data): void {
                SpecificationUnit::create($data);
            })->visible(auth()->guard('admin')->user()->can('create', SpecificationUnit::class));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(SpecificationUnit::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('slug')->sortable()->searchable(isIndividual: true),
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
                            ->rules(['required', 'string'])
                            ->unique('specification_units', 'name', ignoreRecord: true),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->rules(['required', 'string'])
                            ->unique('specification_units', 'slug', ignoreRecord: true),
                    ])->visible(fn (SpecificationUnit $SpecificationUnit) => auth()->guard('admin')->user()->can('update', $SpecificationUnit)),
                ViewAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Name'),
                        TextInput::make('slug')
                            ->label('Slug'),
                    ]),
                DeleteAction::make()->visible(fn (SpecificationUnit $SpecificationUnit) => auth()->guard('admin')->user()->can('delete', $SpecificationUnit))
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn (SpecificationUnit $SpecificationUnit) => auth()->guard('admin')->user()->can('delete', $SpecificationUnit)),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.specification-units');
    }
}
