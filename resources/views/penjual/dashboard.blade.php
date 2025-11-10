<h1>Selamat datang Penjual, {{ Auth::user()->nama }}!</h1>
<form method="POST" action="{{ route('logout') }}">
  @csrf
  <button type="submit">Logout</button>
</form>
