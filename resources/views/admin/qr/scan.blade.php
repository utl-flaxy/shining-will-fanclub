@extends('admin.layouts.app')

@section('content')

<style>
.qr-wrapper {
    max-width: 520px;
    margin: 0 auto;
    padding: 24px;
}

.qr-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 16px;
}

#reader {
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
}

.qr-result {
    margin-top: 16px;
    padding: 14px;
    background: #f4f6f8;
    border-radius: 10px;
    font-size: 14px;
    word-break: break-all;
}
</style>

<div class="qr-wrapper">

    <div class="qr-title">会員QRスキャン</div>

    <div id="reader"></div>

    <div id="result" class="qr-result" style="display:none;">
        <strong>読み取り結果：</strong>
        <div id="result-text"></div>
    </div>

</div>

{{-- QRライブラリ（CDN） --}}
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const resultBox = document.getElementById('result');
    const resultText = document.getElementById('result-text');

    const html5QrCode = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {

            const cameraId = devices[0].id;

            html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: { width: 220, height: 220 }
                },
                qrCodeMessage => {
                    resultText.textContent = qrCodeMessage;
                    resultBox.style.display = 'block';

                    // 一旦止める（連続読取防止）
                    html5QrCode.stop();
                },
                errorMessage => {
                    // 読み取り中のエラーは無視
                }
            );
        }
    }).catch(err => {
        alert('カメラを起動できませんでした');
    });
});
</script>

@endsection
