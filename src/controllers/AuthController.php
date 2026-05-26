<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\FileUpload;
use App\Helpers\Session;
use App\Helpers\Validator;
use App\Models\User;
use App\Models\Player;
use App\Models\Coach;
use App\Models\Team;

/**
 * Class AuthController
 * Handles authentication and registration processes for the MARU platform.
 */
class AuthController
{
    /**
     * Helper to redirect logged-in users to their respective dashboards.
     */
    private function redirectBasedOnRole(?string $role): void
    {
        if ($role === 'admin') {
            redirect('/admin');
        } elseif ($role === 'coach') {
            redirect('/coach/team');
        } else {
            redirect('/player/profile');
        }
    }

    /**
     * Render the login page.
     */
    public function showLogin(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirectBasedOnRole(Session::getUserRole());
        }

        $pageTitle = 'Login - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/login.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/auth.php';
    }

    /**
     * Process the login request.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/login');
        }

        // Validate CSRF token
        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::flash('error', 'Invalid security token. Please try again.');
            redirect('/login');
        }

        // Validate inputs
        $validator = new Validator($_POST);
        $validator->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/login');
        }

        $data = $validator->validated();
        $email = $data['email'];
        $password = $_POST['password'];

        // Look up user by email
        $user = User::findByEmail($email);

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Check if user is active
            if (isset($user['is_active']) && (int)$user['is_active'] === 1) {
                // Regenerate session ID to prevent fixation
                session_regenerate_id(true);
                
                // Set user in session (omit password hash)
                unset($user['password']);
                Session::setUser($user);
                
                // Set flash success message
                Session::flash('success', 'Login successful. Welcome back!');
                
                // Redirect to role dashboard
                $this->redirectBasedOnRole($user['role'] ?? null);
            } else {
                Session::flash('error', 'Your account is currently inactive.');
                redirect('/login');
            }
        }

        Session::flash('error', 'Invalid email or password.');
        redirect('/login');
    }

    /**
     * Render the registration page.
     */
    public function showRegister(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirectBasedOnRole(Session::getUserRole());
        }

        $pageTitle = 'Register - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/register.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/auth.php';
    }

    /**
     * Log out the user.
     */
    public function logout(): void
    {
        // Validate CSRF token for logout
        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            redirect('/');
        }

        // Destroy session
        Session::destroy();
        
        // Redirect to /login
        redirect('/login');
    }

    /**
     * Show player register form
     */
    public function showPlayerRegister(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirectBasedOnRole(Session::getUserRole());
        }

        $pageTitle = 'Player Registration - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/register-player.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/auth.php';
    }

    /**
     * Handle player registration
     */
    public function registerPlayer(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/register/player'));
            exit;
        }

        // Validate CSRF token
        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::flash('error', 'Invalid security token. Please try again.');
            header('Location: ' . url('/register/player'));
            exit;
        }

        $validator = new Validator($_POST);
        $validator->validate([
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'phone' => 'required',
            'position' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: ' . url('/register/player'));
            exit;
        }

        $data = $validator->validated();

        // Check if email already exists
        if (User::findByEmail($data['email'])) {
            Session::flash('error', 'Email is already registered.');
            Session::flash('old', $_POST);
            header('Location: ' . url('/register/player'));
            exit;
        }

        // Handle avatar upload
        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_DIR . '/avatars';
            $result = FileUpload::upload($_FILES['avatar'], $uploadDir, ['jpg', 'jpeg', 'png'], MAX_FILE_SIZE);
            if ($result['success']) {
                $avatarPath = $result['file_path'];
            } else {
                Session::flash('error', 'Avatar upload failed: ' . $result['error']);
                Session::flash('old', $_POST);
                header('Location: ' . url('/register/player'));
                exit;
            }
        }

        // Create User
        $userData = [
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'role' => 'player'
        ];
        if ($avatarPath) {
            $userData['avatar'] = $avatarPath;
        }
        $userId = User::create($userData);

        if ($userId) {
            // Create Player Profile
            $playerCreated = Player::create($userId, [
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'nationality' => $data['nationality'],
                'position' => $data['position']
            ]);

            if ($playerCreated) {
                // Log them in immediately
                $user = User::findByEmail($data['email']);
                unset($user['password']);
                session_regenerate_id(true);
                Session::setUser($user);

                Session::flash('success', 'Registration successful. Welcome to MARU!');
                header('Location: ' . url('/player/profile'));
                exit;
            } else {
                Session::flash('error', 'Failed to create player profile. Please contact support.');
            }
        } else {
            Session::flash('error', 'Registration failed. Please try again.');
        }

        header('Location: ' . url('/register/player'));
        exit;
    }

    /**
     * Show coach register form
     */
    public function showCoachRegister(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirectBasedOnRole(Session::getUserRole());
        }

        $teams = Team::getAll();
        
        $pageTitle = 'Coach Registration - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/register-coach.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/auth.php';
    }

    /**
     * Handle coach registration
     */
    public function registerCoach(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('/register/coach'));
            exit;
        }

        // Validate CSRF token
        $csrf = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrf)) {
            Session::flash('error', 'Invalid security token. Please try again.');
            header('Location: ' . url('/register/coach'));
            exit;
        }

        $validator = new Validator($_POST);
        $validator->validate([
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'date_of_birth' => 'required|date',
            'qualification' => 'required',
            'years_experience' => 'required',
            'coaching_specialty' => 'required',
            'team_id' => 'required'
        ]);

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: ' . url('/register/coach'));
            exit;
        }

        $data = $validator->validated();

        // Check if email already exists
        if (User::findByEmail($data['email'])) {
            Session::flash('error', 'Email is already registered.');
            Session::flash('old', $_POST);
            header('Location: ' . url('/register/coach'));
            exit;
        }

        // Handle avatar upload
        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = UPLOAD_DIR . '/avatars';
            $result = FileUpload::upload($_FILES['avatar'], $uploadDir, ['jpg', 'jpeg', 'png'], MAX_FILE_SIZE);
            if ($result['success']) {
                $avatarPath = $result['file_path'];
            } else {
                Session::flash('error', 'Avatar upload failed: ' . $result['error']);
                Session::flash('old', $_POST);
                header('Location: ' . url('/register/coach'));
                exit;
            }
        }

        // Create User
        $userData = [
            'email' => $data['email'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role' => 'coach'
        ];
        if ($avatarPath) {
            $userData['avatar'] = $avatarPath;
        }
        $userId = User::create($userData);

        if ($userId) {
            // Create Coach Profile
            $coachCreated = Coach::create($userId, [
                'phone' => $data['phone'],
                'address' => $_POST['address'] ?? null,
                'date_of_birth' => $data['date_of_birth'],
                'qualification' => $data['qualification'],
                'years_experience' => (int)$data['years_experience'],
                'coaching_specialty' => $data['coaching_specialty'],
                'team_id' => $data['team_id']
            ]);

            if ($coachCreated) {
                // Log them in immediately
                $user = User::findByEmail($data['email']);
                unset($user['password']);
                session_regenerate_id(true);
                Session::setUser($user);

                Session::flash('success', 'Registration successful. Welcome to MARU!');
                header('Location: ' . url('/coach/profile'));
                exit;
            } else {
                Session::flash('error', 'Failed to create coach profile. Please contact support.');
            }
        } else {
            Session::flash('error', 'Registration failed. Please try again.');
        }

        header('Location: ' . url('/register/coach'));
        exit;
    }
}
