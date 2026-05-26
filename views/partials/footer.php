<footer class="footer">
    <div class="container">
        <div class="grid grid-4 gap-8">
            <div>
                <a href="<?= url('/') ?>" class="navbar-brand mb-4">
                    <i class="ph-fill ph-rugby text-2xl text-primary"></i> MARU
                </a>
                <p class="text-muted text-sm mt-2">
                    Malawi Rugby Union Online Player Registration System. Streamlining the registration process for players, coaches, and administrators.
                </p>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="text-secondary text-lg no-underline" aria-label="Facebook">
                        <i class="ph ph-facebook-logo"></i>
                    </a>
                    <a href="#" class="text-secondary text-lg no-underline" aria-label="Twitter">
                        <i class="ph ph-twitter-logo"></i>
                    </a>
                    <a href="#" class="text-secondary text-lg no-underline" aria-label="Instagram">
                        <i class="ph ph-instagram-logo"></i>
                    </a>
                    <a href="#" class="text-secondary text-lg no-underline" aria-label="YouTube">
                        <i class="ph ph-youtube-logo"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="heading-4 text-base mb-4">Quick Links</h4>
                <ul class="flex-col gap-2 list-unstyled">
                    <li><a href="<?= url('/') ?>" class="text-secondary text-sm no-underline">Home</a></li>
                    <li><a href="<?= url('/register') ?>" class="text-secondary text-sm no-underline">Register</a></li>
                    <li><a href="<?= url('/login') ?>" class="text-secondary text-sm no-underline">Login</a></li>
                </ul>
            </div>

            <div>
                <h4 class="heading-4 text-base mb-4">For Players</h4>
                <ul class="flex-col gap-2 list-unstyled">
                    <li><a href="<?= url('/player/profile') ?>" class="text-secondary text-sm no-underline">My Profile</a></li>
                    <li><a href="<?= url('/player/status') ?>" class="text-secondary text-sm no-underline">Registration Status</a></li>
                    <li><a href="<?= url('/player/profile/edit') ?>" class="text-secondary text-sm no-underline">Edit Profile</a></li>
                </ul>
            </div>

            <div>
                <h4 class="heading-4 text-base mb-4">Contact Us</h4>
                <ul class="flex-col gap-2 text-muted text-sm list-unstyled">
                    <li class="flex items-center gap-2"><i class="ph ph-map-pin"></i> Kamuzu Stadium, Blantyre</li>
                    <li class="flex items-center gap-2"><i class="ph ph-envelope"></i> info@maru.mw</li>
                    <li class="flex items-center gap-2"><i class="ph ph-phone"></i> +265 888 123 456</li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-6 footer-divider text-center">
            <p class="text-muted text-xs">
                &copy; <?= date('Y') ?> Malawi Rugby Union (MARU). All rights reserved.
            </p>
        </div>
    </div>
</footer>
