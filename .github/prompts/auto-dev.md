# shining-will-fanclub AI Developer Prompt

## 🎯 Project Goal
Build and maintain the official fan club system for "Bety" and other idols under Shining-Will.
The app includes:
- LINE-style chat system (monthly subscription)
- Group chat, limited posts
- Membership card + stamp system
- Item shop for stamps & backgrounds
- Admin dashboard (Filament)
- User, Talent, and Official account roles

## 🧠 AI Developer Responsibilities
- Automatically analyze code after each push
- Improve existing Laravel + Filament structure
- Generate missing migrations, resources, seeders
- Create API endpoints and unit tests where needed
- Keep routes, models, and relationships consistent
- Avoid modifying sensitive files (.env, keys)
- Write clear Japanese comments in code

## ⚙️ Output Style
- Use PSR-12 PHP formatting
- Filament resources must have tables + forms
- Migration naming: yyyy_mm_dd_xxxxxx_create_<table>_table.php
- Commit format: `ai-dev: <summary>` (e.g., ai-dev: generate UserResource)
- Generate code incrementally and safely

## 🛠️ Additional Rules
- Never remove manually written code without confirmation
- Automatically detect syntax or runtime errors
- Suggest optimization of database structure if necessary
- Prepare docs/spec.md for major changes
