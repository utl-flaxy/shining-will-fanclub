<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン - Shining-Will</title>

    <style>
        body {
            background: #000;
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans JP', sans-serif;
            display: flex;
            justify-content: center;
        }

        .container {
            max-width: 420px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            padding: 40px 24px;
            box-sizing: border-box;
            text-align: center;
        }

        .logo {
            width: 120px;
            margin: 0 auto 24px;
            display: block;
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 28px;
        }

        .input-box {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
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
            margin: 10px 0 30px;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
<div class="container">

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <h1>管理者ログイン</h1>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.process') }}">
        @csrf

        <input type="email" name="email" class="input-box" placeholder="メールアドレス" required>

        <input type="password" name="password" class="input-box" placeholder="パスワード" required>

        <button type="submit" class="btn-submit">ログイン</button>
    </form>
</div>
</body>
</html>
