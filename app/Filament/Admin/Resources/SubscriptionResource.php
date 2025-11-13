<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationGroup = 'サブスク管理';
    protected static ?string $navigationLabel = '会員サブスク';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('ユーザー')
                ->options(User::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\Select::make('plan_id')
                ->label('プラン')
                ->options(Plan::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('stripe_customer_id')
                ->label('Stripe Customer ID')
                ->required(),

            Forms\Components\TextInput::make('stripe_subscription_id')
                ->label('Stripe Subscription ID')
                ->required(),

            Forms\Components\TextInput::make('status')
                ->label('ステータス')
                ->helperText('active / canceled / past_due など'),

            Forms\Components\DateTimePicker::make('current_period_end')
                ->label('次回支払期限'),

            Forms\Components\DateTimePicker::make('canceled_at')
                ->label('解約日時'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('ユーザー')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('plan.name')
                ->label('プラン')
                ->sortable(),

            Tables\Columns\TextColumn::make('status')
                ->label('状態')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'active' => 'success',
                    'past_due' => 'warning',
                    'canceled' => 'danger',
                    default => 'gray'
                }),

            Tables\Columns\TextColumn::make('current_period_end')
                ->dateTime()
                ->label('次回期限'),

            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->label('更新日時'),
        ])
        ->actions([ Tables\Actions\EditAction::make() ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit'   => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
