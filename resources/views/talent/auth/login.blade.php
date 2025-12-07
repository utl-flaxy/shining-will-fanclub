<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タレントログイン - Shining-Will</title>

    <style>
        body {
            background: #000;
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        .login-wrapper {
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            text-align: center;
            padding: 50px 25px;
            box-sizing: border-box;
        }

        .logo {
            width: 120px;
            margin: 0 auto 35px;
            display: block;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .sub-text {
            font-size: 13px;
            color: #666;
            margin-bottom: 35px;
        }

        .form-container {
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            font-size: 14px;
            background: #fafafa;
            box-sizing: border-box;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            margin-top: 5px;
            background: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            font-weight: 600;
        }

        .login-btn:hover {
            background: #111;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        {{-- ロゴ --}}
        <img src="{{ asset('images/logo.png') }}" class="logo" alt="logo">

        {{-- タイトル --}}
        <h1>タレントログイン</h1>
        <div class="sub-text">
            タレント専用アカウントでログインしてください
        </div>

        <div class="form-container">
            <form method="POST" action="{{ route('talent.login.post') }}">
                @csrf

                {{-- メールアドレス --}}
                <input
                    type="email"
                    name="email"
                    placeholder="メールアドレス"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >

                {{-- パスワード --}}
                <input
                    type="password"
                    name="password"
                    placeholder="パスワード"
                    required
                >

                {{-- エラー表示 --}}
                @if ($errors->any())
                    <div class="error">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- ログインボタン --}}
                <button type="submit" class="login-btn">
                    ログイン
                </button>
            </form>
        </div>

    </div>
</body>
</html>
