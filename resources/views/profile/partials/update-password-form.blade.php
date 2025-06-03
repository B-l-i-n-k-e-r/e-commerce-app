<div>
    <h3>Update Password</h3>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password">Current Password</label>
            <input id="current_password" type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning">Change Password</button>
    </form>
</div>
