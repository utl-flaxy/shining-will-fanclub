<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = '投稿管理';
    protected static ?string $navigationLabel = '投稿一覧';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('user_id')
                ->label('投稿者')
                ->options(User::all()->pluck('name', 'id'))
                ->required()
                ->searchable(),

            Forms\Components\TextInput::make('title')
                ->label('タイトル')
                ->required(),

            Forms\Components\RichEditor::make('body')
                ->label('本文')
                ->toolbarButtons([
                    'bold', 'italic', 'strike', 'link',
                    'h2', 'h3', 'blockquote', 'codeBlock',
                    'bulletList', 'orderedList',
                ])
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('image_path')
                ->label('画像（任意）')
                ->directory('posts')
                ->image()
                ->maxSize(10_000),

            Forms\Components\TextInput::make('video_url')
                ->label('動画URL（任意）')
                ->placeholder('例: https://youtu.be/xxxx')
                ->url(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('image_path')
                    ->label('画像')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('タイトル')
                    ->limit(40)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('投稿者')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('投稿日')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
