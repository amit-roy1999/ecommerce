<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SpecificationName;
use App\Models\SpecificationUnit;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
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

class Products extends Component implements HasForms, HasActions, HasTable
{
    use InteractsWithForms, InteractsWithActions, InteractsWithTable;

    public string $customErrorMessage  = '';

    public function createProductAction(): Action
    {
        return Action::make('CreateProduct')
            // ->modalWidth('screen')
            ->steps([
                Step::make('Product Details')
                    ->description('Give the Product Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->live(false, 500)
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if ($state !== null) {
                                    $set('slug', (string)str($state)->slug());
                                }
                            })
                            ->rules(['required', 'string', 'unique:products,name'])
                            ->columnSpan(3),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->columnSpan(3)
                            ->rules(['required', 'string', 'unique:products,slug']),
                        Select::make('category_id')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => Category::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                            ->options(Category::pluck('name', 'id')->toArray())
                            ->columnSpan(3)
                            ->rules(['required', 'integer']),
                        Select::make('brand_id')
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => Brand::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                            ->options(Brand::pluck('name', 'id')->toArray())
                            ->columnSpan(3)
                            ->rules(['required', 'integer']),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->step(0.01)
                            ->columnSpan(2)
                            ->rules(['required', 'numeric', 'between:1,999999999999.99']),
                        TextInput::make('avalebel_discount_in_percentage')
                            ->label('Discount')
                            ->suffix('%')
                            ->numeric()
                            ->step(0.01)
                            ->columnSpan(2)
                            ->rules(['required', 'numeric', 'between:1,99.99']),
                        TextInput::make('display_price')
                            ->label('Display Price')
                            ->disabled()
                            ->columnSpan(2),
                        RichEditor::make('description')->columnSpan(6),
                    ])
                    ->columns(6),
                Step::make('Product Specifications')
                    ->description('Give the Product Specification Details')
                    ->schema([
                        Repeater::make('product_specifications')
                            ->schema([
                                Select::make('specification_name_id')
                                    ->label('specification name')
                                    ->searchable()
                                    ->getSearchResultsUsing(fn (string $search): array => SpecificationName::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                                    ->options(SpecificationName::pluck('name', 'id')->toArray())
                                    ->rules(['required', 'integer']),
                                Select::make('specification_unit_id')
                                    ->label('specification unit')
                                    ->searchable()
                                    ->getSearchResultsUsing(fn (string $search): array => SpecificationUnit::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                                    ->options(SpecificationUnit::pluck('name', 'id')->toArray())
                                    ->nullable()
                                    ->rules(['nullabel', 'integer']),
                                TextInput::make('specification_value')
                                    ->rules(['required', 'string']),
                            ])
                            ->columns(3)
                    ]),
                Step::make('Product Images')
                    ->description('Give the Product Details')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Main Product Image')
                            ->image()
                            ->rules(['required', 'image']),
                        FileUpload::make('images')
                            ->multiple()
                            ->label('Other Images')
                            ->image()
                            ->rules(['required', 'image']),
                    ]),
            ])
            ->action(function (array $data): void {
                dd($data);
                Product::create($data);
            })
            ->visible(auth()->guard('admin')->user()->can('create', Product::class));
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query())
            ->columns([
                TextColumn::make('id')->rowIndex()->sortable(),
                ImageColumn::make('image')->circular(),
                ImageColumn::make('images.url')->circular()->stacked(),
                TextColumn::make('name')->sortable()->searchable(isIndividual: true),
                TextColumn::make('slug')->sortable()->searchable(isIndividual: true),
                TextColumn::make('category.name')->badge()->searchable(isIndividual: true),
                TextColumn::make('brand.name')->badge()->searchable(isIndividual: true),
                TextColumn::make('price')->sortable()->searchable(isIndividual: true),
                TextColumn::make('avalebel_discount_in_percentage')->sortable()->searchable(isIndividual: true),
                TextColumn::make('description'),
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
        return view('livewire.products');
    }
}
