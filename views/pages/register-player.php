<?php $layout = 'auth'; ?>
<div class="auth-container">
    <div class="card auth-card">
        <h2 class="auth-title">Player Registration</h2>
        <p class="auth-subtitle">Join the MARU Rugby Union</p>
        
        <form method="POST" action="/register/player">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
            
            <h3 class="section-title">Personal Information</h3>
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label" for="first_name">First Name</label>
                    <input class="form-input" type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="last_name">Last Name</label>
                    <input class="form-input" type="text" id="last_name" name="last_name" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-input" type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="form-input" type="password" id="password" name="password" required>
            </div>
            
            <h3 class="section-title">Rugby Information</h3>
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label" for="date_of_birth">Date of Birth</label>
                    <input class="form-input" type="date" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="gender">Gender</label>
                    <select class="form-input" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label" for="nationality">Nationality</label>
                    <input class="form-input" type="text" id="nationality" name="nationality" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="position">Preferred Position</label>
                    <select class="form-input" id="position" name="position" required>
                        <option value="">Select Position</option>
                        <option value="forward">Forward</option>
                        <option value="back">Back</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input class="form-input" type="tel" id="phone" name="phone" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Register as Player</button>
        </form>
    </div>
</div>
