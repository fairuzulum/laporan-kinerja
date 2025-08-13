<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ Auth::user()->name }} (Role: {{ Auth::user()->role }})</h1>
    <a href="{{ route('profile.edit') }}">Update Profile</a><br>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>