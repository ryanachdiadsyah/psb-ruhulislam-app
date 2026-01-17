<h1>Logged in</h1>

<form action="/logout" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>