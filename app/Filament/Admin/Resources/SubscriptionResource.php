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

    /**
     * ✅ フォーム（Stripe 無効）
     */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('ユーザー')
                ->options(User::query()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\Select::make('plan_id')
                ->label('プラン')
                ->options(Plan::query()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\Select::make('status')
                ->label('ステータス')
                ->options([
                    'active'   => '有効',
                    'canceled' => '解除',
                    'paused'   => '一時停止',
                ])
                ->default('active')
                ->required(),

            Forms\Components\DateTimePicker::make('current_period_end')
                ->label('有効期限')
                ->helperText('Stripe未使用時の手動管理用')
                ->nullable(),
        ]);
    }

    /**
     * ✅ 一覧テーブル（Stripe 無効）
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                        'active'   => 'success',
                        'paused'   => 'warning',
                        'canceled' => 'danger',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('current_period_end')
                    ->label('有効期限')
                    ->dateTime()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新日時')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    /**
     * ✅ ページ定義
     */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit'   => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
