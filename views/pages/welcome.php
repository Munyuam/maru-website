<?php
// Welcome page template
?>
<div class="welcome-container">
    <div class="welcome-content">
        <h1 class="welcome-title">Welcome to the Rugby Player Registration System</h1>
        
        <div class="welcome-logo-wrapper">
            <div class="welcome-logo-circle">
                <img src="<?= url('/public/assets/logo.png') ?>" alt="MARU Logo" class="welcome-logo-img">
            </div>
        </div>
        
        <div class="welcome-text-group">
            <p class="welcome-desc">Thank you for choosing our system to register your players. We are committed to providing you with the best experience possible.</p>
            <p class="welcome-action-text">Please click on the buttons below to login or register.</p>
        </div>
        
        <div class="welcome-buttons">
            <div class="welcome-buttons-top">
                <a href="<?= url('/login') ?>" class="welcome-btn btn-login">Login</a>
            </div>
            <div class="welcome-buttons-bottom">
                <a href="<?= url('/register/player') ?>" class="welcome-btn btn-register">Register as Player</a>
                <a href="<?= url('/register/coach') ?>" class="welcome-btn btn-register">Register as Coach</a>
            </div>
        </div>
        
        <footer class="welcome-footer">
            Malawi rugby union@2023
        </footer>
    </div>
</div>

<style>
.welcome-container {
    min-height: 100vh;
    width: 100%;
    background: radial-gradient(circle, #ff1a1a 0%, #cc0000 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1.5rem;
    box-sizing: border-box;
}

.welcome-content {
    max-width: 800px;
    width: 100%;
    text-align: center;
    color: #ffffff;
}

.welcome-title {
    font-family: var(--font-serif), Georgia, serif;
    font-style: italic;
    font-size: 2.5rem;
    font-weight: 500;
    margin-bottom: 3rem;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
}

.welcome-logo-wrapper {
    margin-bottom: 3rem;
}

.welcome-logo-circle {
    width: 180px;
    height: 180px;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    border: 6px solid #ffffff;
    outline: 2px solid rgba(255, 255, 255, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.welcome-logo-circle:hover {
    transform: scale(1.00);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

.welcome-logo-img {
    width: 150px;
    height: 150px;
    object-fit: contain;
}

.welcome-text-group {
    margin-bottom: 3.5rem;
}

.welcome-desc, .welcome-action-text {
    font-family: var(--font-serif), Georgia, serif;
    font-style: italic;
    font-size: 1.2rem;
    line-height: 1.6;
    max-width: 650px;
    margin: 0 auto 1.25rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.welcome-buttons {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    align-items: center;
    margin-bottom: 4rem;
}

.welcome-buttons-bottom {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.welcome-btn {
    background: #ffffff;
    color: #000000 !important;
    font-family: var(--font-serif), Georgia, serif;
    font-style: italic;
    font-weight: 700;
    text-decoration: none;
    padding: 0.75rem 2.25rem;
    border-radius: 6px;
    font-size: 1.25rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    min-width: 180px;
    text-align: center;
    display: inline-block;
}

.welcome-btn:hover {
    background: #f1f5f9;
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.welcome-btn:active {
    transform: translateY(0);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
}

.welcome-footer {
    font-family: var(--font-sans), sans-serif;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    margin-top: 2rem;
    letter-spacing: 0.03em;
}

@media (max-width: 600px) {
    .welcome-title {
        font-size: 1.85rem;
    }
    .welcome-desc, .welcome-action-text {
        font-size: 1.05rem;
    }
    .welcome-buttons-bottom {
        flex-direction: column;
        gap: 1rem;
        width: 100%;
    }
    .welcome-btn {
        width: 100%;
        box-sizing: border-box;
    }
}
</style>
