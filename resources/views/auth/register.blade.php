{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント作成 - Shining-Will Fanclub</title>

    <style>
        body {
            margin: 0;
            background: #000;
            font-family: "Hiragino Sans", "Noto Sans JP", sans-serif;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 420px;
            background: #fff;
            min-height: 100vh;
            padding: 40px 28px;
            box-sizing: border-box;
            text-align: center;
        }

        /* ロゴ */
        .logo {
            width: 110px;
            margin: 0 auto 24px;
            display: block;
        }

        /* タイトル */
        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 28px;
        }

        /* 入力フォーム */
        .input-box {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            margin-bottom: 14px;
            box-sizing: border-box;
        }

        /* エラー表示 */
        .error-text {
            color: #e53935;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
            text-align: left;
        }

        /* 登録ボタン */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            margin: 18px 0 30px;
            cursor: pointer;
        }

        /* リンク類 */
        .links a {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>

<div class="container">

    {{-- ロゴ --}}
    <img src="{{ asset('images/logo.png') }}" class="logo" alt="logo">

    {{-- タイトル --}}
    <h1>アカウント作成</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- 名前（本名） --}}
        <input type="text" name="name" class="input-box" placeholder="お名前（本名）" value="{{ old('name') }}" required>
        @error('name')
            <div class="error-text">{{ $message }}</div>
        @enderror

        {{-- ニックネーム --}}
        <input type="text" name="nickname" class="input-box" placeholder="ニックネーム（サイト上で表示）" value="{{ old('nickname') }}" required>
        @error('nickname')
            <div class="error-text">{{ $message }}</div>
        @enderror

        {{-- メール --}}
        <input type="email" name="email" class="input-box" placeholder="メールアドレス" value="{{ old('email') }}" required>
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror

        {{-- パスワード --}}
        <input type="password" name="password" class="input-box" placeholder="パスワード" required>
        @error('password')
            <div class="error-text">{{ $message }}</div>
        @enderror

        {{-- パスワード確認 --}}
        <input type="password" name="password_confirmation" class="input-box" placeholder="パスワード（確認）" required>

        {{-- 送信 --}}
        <button type="submit" class="btn-submit">登録</button>
    </form>

    {{-- リンク --}}
    <div class="links">
        <a href="{{ route('login') }}">ログインへ戻る</a>
        <a href="#">利用規約 / プライバシーポリシー</a>
    </div>

</div>

</body>
</html>
