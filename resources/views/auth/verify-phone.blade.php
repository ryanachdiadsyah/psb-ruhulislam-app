<form method="POST" action="{{ route('phone.verify') }}">
    @csrf

    <input type="text" name="otp" placeholder="Enter OTP">

    @error('otp')
        <div>{{ $message }}</div>
    @enderror

    <button type="submit">Verify</button>
</form>