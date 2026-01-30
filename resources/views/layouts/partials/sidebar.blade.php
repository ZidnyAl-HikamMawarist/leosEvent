<div class="col-md-2 sidebar p-3">
    <h5 class="text-white text-center mb-4">ADMIN PANEL</h5>

    <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
    <a href="/admin/lomba" class="{{ request()->is('admin/lomba*') ? 'active' : '' }}">🏆 Lomba</a>
    <a href="/admin/galeri" class="{{ request()->is('admin/galeri*') ? 'active' : '' }}">🖼 Galeri</a>
    <a href="/admin/faq" class="{{ request()->is('admin/faq*') ? 'active' : '' }}">❓ FAQ</a>
    <a href="/admin/settings" class="{{ request()->is('admin/settings*') ? 'active' : '' }}">⚙ Settings</a>

    <hr class="text-secondary">

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>
</div>
