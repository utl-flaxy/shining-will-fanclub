<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'サブスク管理';
    protected static ?string $navigationLabel = 'プラン一覧';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('プラン名')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('description')
                ->label('説明文（任意）')
                ->maxLength(500),

            Forms\Components\TextInput::make('price')
                ->label('月額料金（円）')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('stripe_price_id')
                ->label('Stripe Price ID')
                ->required()
                ->helperText('例: price_xxxxxxxxxxxxxx'),

            Forms\Components\Toggle::make('is_active')
                ->label('有効フラグ')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('プラン名')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('料金(円)')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('有効'),

                Tables\Columns\TextColumn::make('stripe_price_id')
                    ->label('Stripe Price ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('作成日')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit'   => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
