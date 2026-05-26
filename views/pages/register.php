<?php
// Register page role selection
?>
<div class="register-wrapper">
    <div class="register-logo-wrapper">
        <div class="register-logo-circle">
            <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" class="register-logo-img">
        </div>
    </div>
    
    <div class="register-form-card" style="max-width: 500px;">
        <h2 class="login-heading" style="margin-bottom: 0.5rem;">Join MARU</h2>
        <p class="text-center mb-6" style="color: #ffffff; font-family: var(--font-serif), Georgia, serif; font-style: italic; font-size: 1.1rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Select your role to get started</p>
        
        <div class="grid grid-2 gap-4">
            <a href="<?= url('/register/player') ?>" class="no-underline">
                <div class="card card-hover p-6 text-center role-select-card">
                    <div class="text-4xl mb-2">🏃</div>
                    <h3 class="heading-4 role-select-title">Player</h3>
                    <p class="text-sm text-muted mt-2">Register to play in the league</p>
                </div>
            </a>

            <a href="<?= url('/register/coach') ?>" class="no-underline">
                <div class="card card-hover p-6 text-center role-select-card">
                    <div class="text-4xl mb-2">📋</div>
                    <h3 class="heading-4 role-select-title">Coach</h3>
                    <p class="text-sm text-muted mt-2">Register to manage a team</p>
                </div>
            </a>
        </div>
        
        <div class="text-center mt-6">
            <p style="color: #ffffff; font-size: 0.875rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Already have an account? <a href="<?= url('/login') ?>" style="color: #ffffff; font-weight:700; text-decoration: underline;">Back to Login</a></p>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <a href="<?= url('/') ?>" style="color: #ffffff; font-weight: 600; font-size: 0.875rem; text-decoration: none; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">← Back to Home</a>
    </div>
</div>

<style>
.role-select-card {
    border: 2px solid var(--color-border);
    border-radius: var(--radius-lg);
    background-color: #ffffff;
    transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}

.role-select-card:hover {
    transform: translateY(-4px);
    border-color: var(--color-primary);
    box-shadow: 0 8px 16px rgba(255, 0, 0, 0.1);
}

.role-select-title {
    color: #000000;
    font-weight: 700;
    margin-top: 0.5rem;
}
</style>
