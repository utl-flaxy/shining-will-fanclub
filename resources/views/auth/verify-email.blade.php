{{-- resources/views/auth/verify-email.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メール確認 - Shining-Will Fanclub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            background: #000;
            margin: 0;
            padding: 0;
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
            height: auto;
            margin: 0 auto 24px;
            display: block;
        }

        h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .status {
            background: #e8fff3;
            border: 1px solid #b2f1d0;
            color: #0a7;
            font-size: 14px;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 24px;
        }

        .btn-primary {
            width: 100%;
            background: #000;
            color: #fff;
            padding: 14px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .btn-link {
            display: block;
            color: #666;
            font-size: 14px;
            text-decoration: none;
            margin-top: 8px;
        }

        .btn-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<div class="container">

    {{-- ロゴ --}}
    <img src="{{ asset('images/logo.png') }}" class="logo" alt="logo">

    <h1>メールアドレス確認</h1>

    <p>
        アカウントを有効化するため、登録メールアドレスに確認リンクを送信しています。<br>
        メールのリンクをクリックして認証を完了してください。
    </p>

    {{-- リンク再送メッセージ --}}
    @if (session('status') == 'verification-link-sent')
        <div class="status">
            新しい確認メールを送信しました！
        </div>
    @endif

    {{-- 再送ボタン --}}
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn-primary">確認メールを再送する</button>
    </form>

    {{-- ログアウト --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="#" onclick="this.closest('form').submit()" class="btn-link">
            ログアウトする
        </a>
    </form>

</div>
</body>
</html>
