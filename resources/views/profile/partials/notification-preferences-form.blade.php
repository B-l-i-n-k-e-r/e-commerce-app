<div>
    <h3>Notification Preferences</h3>
    <form method="POST" action="{{ route('profile.update.notifications') }}">
        @csrf
        @method('PATCH')

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="email_notifications" id="email_notifications"
                   {{ auth()->user()->email_notifications ? 'checked' : '' }}>
            <label class="form-check-label" for="email_notifications">
                Receive Email Notifications
            </label>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="sms_notifications" id="sms_notifications"
                   {{ auth()->user()->sms_notifications ? 'checked' : '' }}>
            <label class="form-check-label" for="sms_notifications">
                Receive SMS Notifications
            </label>
        </div>
