<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Categories extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public string $customErrorMessage  = '';

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
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->rules(['required', 'image']),

            ])
            ->action(function (array $data): void {
                Category::create($data);
            })->visible(auth()->guard('admin')->user()->can('create', Category::class));
    }

    public function createChildCategoryAction(): Action
    {
        return Action::make('CreateChildCategory')
            ->form([
                Select::make('parent_id')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => Category::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn ($value): ?string => Category::find($value)?->name)
                    ->rules(['required', 'integer']),
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
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->rules(['required', 'image']),

            ])
            ->action(function (array $data): void {
                Category::create($data);
            })->visible(auth()->guard('admin')->user()->can('create', Category::class));
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Category::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                ImageColumn::make('image')->circular(),
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
                            ->rules(['required', 'string'])
                            ->unique('categories', 'name', ignoreRecord: true),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->rules(['required', 'string'])
                            ->unique('categories', 'slug', ignoreRecord: true),
                        FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->rules(['required', 'image']),
                    ])->visible(fn (Category $category) => auth()->guard('admin')->user()->can('update', $category)),
                ViewAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Name'),
                        TextInput::make('email')
                            ->label('Email'),
                        FileUpload::make('image')
                            ->image()
                    ]),
                DeleteAction::make()
                    // ->modalDescription('Deleteing this category will delete all the category under this category and their images')
                    ->action(function (Category $category) {
                        deleteImageIfExists('public', $category->image);
                        try {
                            $category->delete();
                        } catch (\Illuminate\Database\QueryException $th) {
                            return $this->customErrorMessage = 'Can not delete this category without deleteing all the child categories under it.';
                        }
                    })
                    // ->failureNotificationMessage('User deleted')
                    ->visible(fn (Category $category) => auth()->guard('admin')->user()->can('delete', $category))
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->modalDescription('Deleteing this category will delete all the category under this category and their images')
                        ->visible(fn (Category $category) => auth()->guard('admin')->user()->can('delete', $category)),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.categories');
    }
}
