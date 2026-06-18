# Shining Will Fanclub

地下アイドル・アーティスト向けの会員制ファンクラブシステム

Laravel 11 を用いて開発した Web アプリケーションです。

単なる CRUD アプリではなく、

- 権限管理
- DM機能
- ショップ機能
- デジタル会員証
- 管理画面
- 購入履歴
- 未読管理

など、実際の運用を意識して設計しました。

---

# URL

### User

```
/members
```

### Admin

```
/admin
```

---

# デモ画像

|ホーム|トーク|
|---|---|
|Home画面|DM画面|

（スクリーンショット追加予定）

---

# 使用技術

## Backend

- PHP 8.3
- Laravel 11

## Frontend

- Blade
- HTML
- CSS
- JavaScript

## Database

- MySQL 8

## Authentication

- Laravel Auth
- Spatie Laravel Permission

## Infrastructure

- Ubuntu
- Nginx
- Docker
- ConoHa VPS

---

# 機能一覧

## 一般会員

### ホーム

- 最新メッセージ表示
- 未読件数表示

### トーク

- タレント別DM
- 未読管理
- 時刻表示

### 投稿

- 投稿一覧
- 投稿詳細

### ショップ

- 商品一覧
- 商品詳細
- カート
- 購入確認
- 購入完了

### マイアイテム

購入済みアイテム一覧

### デジタル会員証

- 会員番号表示
- QRコード表示
- タレントカラー対応

### 設定

- アカウント情報変更
- パスワード変更
- 購入履歴
- テーマ変更

---

## タレント

- タレント専用アカウント
- ファンとのDM

---

## 管理者

### 投稿管理

- 投稿作成
- 編集
- 削除

### タレント管理

- タレント作成
- ユーザー紐付け
- カラー管理

### アイテム管理

- 商品登録
- 編集
- 削除

### トーク管理

- DM一覧
- メッセージ送信

### ファン管理

- ファン一覧
- 会員情報確認

### WatchDog

- 通報一覧
- BAN管理

### 設定

- システム設定画面

---

# システム構成

```
Browser
    ↓
Nginx
    ↓
Laravel11
    ↓
MySQL
```

---

# 権限設計

### admin

運営管理者

```
role = admin
```

利用可能機能

- 全機能

---

### talent

タレント

```
role = talent
```

利用可能機能

- DM返信
- 投稿

---

### user

一般会員

```
role = user
```

利用可能機能

- トーク
- 投稿
- ショップ

---

# ER図

## users

会員情報

## talents

タレント情報

## talks

トークルーム

## talk_members

参加者管理

## talk_messages

メッセージ

## talk_reads

既読管理

## posts

投稿

## items

商品

## purchased_items

購入済み商品

## orders

注文

---

# DM機能

ユーザー登録時に Event + Listener を利用し、

タレントとのDMルームを自動生成しています。

### 自動生成内容

Talk

```
Shinin × 山田太郎
```

TalkMember

- タレント側
- ユーザー側

を自動登録しています。

---

# 工夫した点

## ① 権限管理

Spatie Permission を利用し、

- admin
- talent
- user

を分離しました。

---

## ② N+1問題対策

必要な箇所では eager loading を利用しています。

例

```php
Talk::with([
    'members.user',
    'latestMessage'
])->get();
```

---

## ③ アクセサを利用した表示名生成

Talkモデルに

```php
getDisplayNameForUserAttribute()
```

を実装し、

ユーザー画面では

```
Shinin
```

管理者画面では

```
Shinin × 山田太郎
```

となるように設計しました。

---

## ④ 未読管理

talk_reads テーブルを用いて、

既読・未読判定を実装しています。

---

## ⑤ 責務分離

Controller

Service

Model

Blade

の責務を意識して実装しました。

---

# 開発環境

## Clone

```bash
git clone https://github.com/xxxxx/shining-will-fanclub
```

## Docker起動

```bash
docker compose up -d
```

## composer install

```bash
docker compose exec app composer install
```

## .env作成

```bash
cp .env.example .env
```

## key生成

```bash
php artisan key:generate
```

## migration

```bash
php artisan migrate
```

## storage link

```bash
php artisan storage:link
```

---

# ディレクトリ構成

```
app
 ├ Controllers
 │
 ├ Models
 │
 ├ Listeners
 │
 ├ Events
 │
 └ Services

resources
 ├ views
 │
 ├ admin
 │
 ├ members
 │
 └ components

routes
 ├ web.php
 ├ admin.php
 └ members.php
```

---

# インフラ

ConoHa VPS

```
Ubuntu
Nginx
PHP8.3
MySQL8
Docker
```

サーバースペック

```
2 Core
1GB Memory
```

---

# 今後追加予定

- Stripe決済
- サブスク管理
- Push通知
- トーク画像送信
- スタンプ機能
- 背景着せ替え
- PWA化
- iOSアプリ化

---

# 開発者

個人開発

Shining Will Fanclub

Version 1.0