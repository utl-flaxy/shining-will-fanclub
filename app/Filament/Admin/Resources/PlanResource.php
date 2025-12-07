<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon  = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Plans & Subscription';
    protected static ?string $navigationLabel = 'プラン管理';

    /*
    |--------------------------------------------------------------------------
    | Form（作成・編集）
    |--------------------------------------------------------------------------
    */
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('name')
                ->label('プラン名')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('説明')
                ->rows(3)
                ->nullable(),

            Forms\Components\TextInput::make('price')
                ->label('金額（税込）')
                ->numeric()
                ->required()
                ->suffix('円')
                ->minValue(0),

            Forms\Components\Select::make('interval')
                ->label('課金間隔')
                ->options([
                    'month' => '月額',
                    'year'  => '年額',
                ])
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('公開状態')
                ->default(true)
                ->helperText('※ Stripe未連携のため、表示制御のみに使用されます'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Table（一覧）
    |--------------------------------------------------------------------------
    */
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('プラン名')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('金額')
                    ->money('JPY')
                    ->sortable(),

                Tables\Columns\TextColumn::make('interval')
                    ->label('課金間隔')
                    ->formatStateUsing(fn ($state) =>
                        $state === 'month' ? '月額' : '年額'
                    ),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('公開')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->date('Y/m/d')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('公開状態'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit'   => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
