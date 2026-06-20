# 🎤 Shining Will Fanclub

地下アイドル・アーティスト向けの会員制ファンクラブシステムです。

Laravel 11 を用いて開発し、

* 会員管理
* DM機能
* 投稿機能
* EC機能
* デジタル会員証
* 権限管理
* 管理画面

など、実運用を想定した機能を実装しています。

単なるCRUDアプリではなく、

「複数ロールを持つユーザーが継続的に利用するサービス」

をテーマに、

* 権限管理
* メッセージ機能
* 未読管理
* イベント駆動設計
* 保守性を意識した責務分離

を重視して設計しました。

---

# ✅ このプロジェクトで証明できること

* Laravelを用いた実務レベルのバックエンド開発
* 権限管理を考慮したシステム設計
* Event + Listenerを利用したイベント駆動設計
* DM機能・未読管理など状態管理を伴う実装
* N+1問題を考慮したパフォーマンス改善
* Filamentによる管理画面構築
* Docker + VPSによるサーバー構築・公開
* Linux / Nginx / MySQL を用いた運用経験

---

# 🎯 開発背景

地下アイドルやアーティスト向けのファンクラブサービスでは、

* 会員限定コンテンツ
* タレントとファンの交流
* グッズ販売
* 購入履歴管理
* 管理者による運営

など、多くの機能が必要になります。

また、

* 管理者
* タレント
* 一般会員

で利用できる機能が異なるため、

複数ロールを持つユーザー管理と権限制御が重要になります。

本プロジェクトでは、

「会員制コミュニティサービス」

をテーマとして、

実際の運用を意識したファンクラブシステムを構築しました。

---

# 🏗 システム構成

```text
Internet
    ↓
Nginx
    ↓
Laravel 11
    ↓
MySQL
```

---

# 🛠 技術スタック

| 分類              | 技術                 |
| --------------- | ------------------ |
| Language        | PHP 8.3            |
| Framework       | Laravel 11         |
| Admin           | Filament v3        |
| Frontend        | Blade / JavaScript |
| Database        | MySQL              |
| Authentication  | Laravel Auth       |
| Permission      | Spatie Permission  |
| Server          | Ubuntu             |
| Web Server      | Nginx              |
| Container       | Docker             |
| Version Control | Git / GitHub       |
| Infrastructure  | ConoHa VPS         |

---

# ⭐ 主な機能

### 会員機能

* ホーム
* 投稿閲覧
* DM機能
* 未読管理
* 購入履歴
* デジタル会員証

### タレント機能

* 投稿作成
* DM返信

### 管理者機能

* 投稿管理
* 商品管理
* タレント管理
* トーク管理
* 会員管理
* BAN管理
* システム設定
