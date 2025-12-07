{{-- resources/views/auth/confirm-password.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード確認 - Shining-Will Fanclub</title>
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

        .input-box {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 18px;
            font-size: 15px;
            box-sizing: border-box;
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
            margin-top: 8px;
        }
    </style>
</head>

<body>
<div class="container">

    {{-- ロゴ --}}
    <img src="{{ asset('images/logo.png') }}" class="logo" alt="logo">

    <h1>パスワード確認</h1>

    <p>
        セキュリティ保護のため、続行するには<br>
        パスワードをもう一度入力してください。
    </p>

    {{-- エラー表示 --}}
    @if ($errors->any())
        <div style="background:#ffecec; color:#c00; padding:12px; border-radius:10px; font-size:13px; margin-bottom:18px;">
            @foreach ($errors->all() as $error)
                ・{{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- フォーム --}}
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <input
            id="password"
            type="password"
            name="password"
            class="input-box"
            placeholder="パスワード"
            required
            autocomplete="current-password"
        >

        <button type="submit" class="btn-primary">
            確認する
        </button>
    </form>

</div>
</body>
</html>
