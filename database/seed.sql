USE maru_db;

-- Password for all seed users is 'password'
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- Insert Admin
INSERT INTO users (email, password, role, first_name, last_name, is_active) VALUES
('admin@maru.mw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'System', 'Administrator', 1);

-- Insert Coaches (Users)
INSERT INTO users (email, password, role, first_name, last_name, phone, is_active) VALUES
('coach.lions@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'coach', 'John', 'Banda', '+265888123456', 1),
('coach.bulls@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'coach', 'Peter', 'Phiri', '+265999654321', 1);

-- Insert Teams
INSERT INTO teams (team_name, description, coach_id, is_active) VALUES
('Lilongwe Lions', 'Premier rugby team based in Lilongwe.', 2, 1),
('Blantyre Bulls', 'Competitive team from Blantyre.', 3, 1),
('Zomba Zebras', 'Emerging talent from Zomba region.', NULL, 1);

-- Insert Coaches (Profiles)
INSERT INTO coaches (user_id, team_id, date_of_birth, qualification, years_experience, coaching_specialty, registration_status) VALUES
(2, 1, '1980-05-15', 'Level 2 World Rugby Coach', 10, 'Forwards Coach', 'approved'),
(3, 2, '1975-08-22', 'Level 1 World Rugby Coach', 5, 'Backs Coach', 'approved');

-- Insert Players (Users)
INSERT INTO users (email, password, role, first_name, last_name, phone, is_active) VALUES
('player1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'player', 'Chikondi', 'Mbewe', '+265888111222', 1),
('player2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'player', 'Kondwani', 'Nyirenda', '+265999333444', 1),
('player3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'player', 'Yamikani', 'Chirwa', '+265888555666', 1),
('player4@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'player', 'Dalitso', 'Mwale', '+265999777888', 1),
('player5@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'player', 'Madalitso', 'Kadzamira', '+265888999000', 1);

-- Insert Players (Profiles)
INSERT INTO players (user_id, team_id, date_of_birth, gender, nationality, address, position, playing_experience, emergency_contact_name, emergency_contact_phone, registration_status) VALUES
(4, 1, '1995-10-12', 'male', 'Malawian', 'Area 47, Lilongwe', 'Prop', 5, 'Mary Mbewe', '+265888000111', 'approved'),
(5, 1, '1998-03-25', 'male', 'Malawian', 'Area 18, Lilongwe', 'Scrum-half', 3, 'John Nyirenda', '+265999111222', 'pending'),
(6, 2, '1992-07-08', 'male', 'Malawian', 'Namiwawa, Blantyre', 'Fly-half', 8, 'Sarah Chirwa', '+265888222333', 'approved'),
(7, 2, '2000-11-30', 'male', 'Malawian', 'Chinyonga, Blantyre', 'Wing', 2, 'Peter Mwale', '+265999333444', 'rejected'),
(8, 3, '1997-01-14', 'male', 'Malawian', 'Mtiya, Zomba', 'Hooker', 4, 'Grace Kadzamira', '+265888444555', 'pending');

-- Insert Notifications
INSERT INTO notifications (user_id, sender_id, title, message, type) VALUES
(5, 1, 'Registration Pending', 'Your registration is currently under review. Please ensure all documents are uploaded.', 'info'),
(7, 1, 'Registration Rejected', 'Your registration has been rejected due to invalid medical clearance. Please upload a valid document.', 'error');
