# Shining-Will Fanclub - AI Auto Developer Prompt

## Project
Laravel + Filament v3 based fan club management system for idol groups under Shining-Will.
Includes chat-like user features, limited posts, and in-app item shop.

## Goal
Generate Filament resources and Laravel models for:
- UserResource
- FanPostResource
- StampItemResource
- ShopOrderResource
- SubscriptionPlanResource

## Requirements
- All migrations, factories, and seeders should be included.
- Use Japanese labels and timezone: Asia/Tokyo.
- Add soft deletes where appropriate.
- Each resource should include list, create, edit, and view pages.
- Relationships:
  - User hasMany FanPosts
  - User hasMany StampItems
  - ShopOrder belongsTo User and StampItem
- Use Filament tables with search, filter, and sortable columns.
