@component('mail::message')
<p>Hi {{ $name }}</p>
<p>Kami mendapati permintaan Anda untuk mengubah kata sandi pada akun Anda di Neraca Ruang.</p>

@component('mail::panel')
<p>Silahkan reset kata sandi Anda dengan cara klik tautan di bawah ini :</p>
<a href="{{ env('EMAIL_URL').'/auth/forgot-password?token='.$code }}">{{ env('EMAIL_URL').'/auth/forgot-password?token='.$code }}</a>
@endcomponent

<p>Masa berlaku waktu Anda untuk mereset password adalah 5 menit. pastikan anda segera melakukannya.</p>
@endcomponent
