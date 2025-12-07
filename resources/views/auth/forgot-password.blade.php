{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再設定 - Shining-Will Fanclub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            min-height: 100vh;
            background: #fff;
            padding: 40px 28px;
            text-align: center;
            box-sizing: border-box;
        }

        .logo {
            width: 110px;
            margin: 0 auto 24px;
            display: block;
        }

        h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .description {
            font-size: 14px;
            color: #666;
            margin-bottom: 24px;
        }

        .input-box {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 15px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px 0 26px;
        }

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

        .status {
            font-size: 14px;
            color: #0a7;
            margin-bottom: 16px;
        }

        .error-text {
            color: #e53935;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 10px;
            text-align: left;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- ロゴ --}}
    <img src="{{ asset('images/logo.png') }}" class="logo" alt="logo">

    {{-- タイトル --}}
    <h1>パスワード再設定</h1>

    {{-- 説明 --}}
    <div class="description">
        ご登録のメールアドレス宛に、<br>
        パスワード再設定用リンクを送信します。
    </div>

    {{-- 成功メッセージ --}}
    @if (session('status'))
        <div class="status">
            {{ session('status') }}
        </div>
    @endif

    {{-- フォーム --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <input type="email" name="email" class="input-box"
               placeholder="メールアドレス" value="{{ old('email') }}" required>

        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror

        <button class="btn-submit">メールを送信</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">ログインへ戻る</a>
        <a href="#">利用規約 / プライバシーポリシー</a>
    </div>

</div>

</body>
</html>
