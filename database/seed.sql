-- Password for all users: password

-- Users
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (1, 'admin@maru.mw', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'admin', 'System', 'Administrator', '798009868', 'dcdc49f8dc23904ed95b52d1b3ca3f86.jpeg', 1, '2026-05-21 13:47:06');
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (2, 'coach.lions@example.com', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'coach', 'John', 'Banda', '+265888123456', 'd7b1e1d718358a582a1fed8ff106e463.jpg', 1, '2026-05-21 13:47:06');
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (3, 'coach.bulls@example.com', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'coach', 'Peter', 'Phiri', '+265999654321', NULL, 1, '2026-05-21 13:47:06');
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (4, 'player1@example.com', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'player', 'Chikondi', 'Mbewe', '0998877665', '124a6e87daa9fb175a930ee876e32283.jpg', 1, '2026-05-21 13:47:06');
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (5, 'player2@example.com', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'player', 'Kondwani', 'Nyirenda', '+265999333444', NULL, 1, '2026-05-21 13:47:06');
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (6, 'player3@example.com', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'player', 'Yamikani', 'Chirwa', '+265888555666', NULL, 1, '2026-05-21 13:47:06');
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (7, 'player4@example.com', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'player', 'Dalitso', 'Mwale', '+265999777888', NULL, 1, '2026-05-21 13:47:06');
INSERT INTO users (id, email, password, role, first_name, last_name, phone, avatar, is_active, created_at) VALUES (8, 'player5@example.com', '$2y$12$Lygh7K/vAceMSDQhHbi6Uu0oZmUInQwFmn.7JiaDLRM7Mp38YURFm', 'player', 'Madalitso', 'Kadzamira', '+265888999000', NULL, 1, '2026-05-21 13:47:06');

-- Teams
INSERT INTO teams (id, name, division, description, coach_id, max_players, is_active, created_at) VALUES (1, 'Lilongwe Lions', NULL, 'Premier rugby team based in Lilongwe.', '2', 30, 1, '2026-05-21 13:47:06');
INSERT INTO teams (id, name, division, description, coach_id, max_players, is_active, created_at) VALUES (2, 'Blantyre Bulls', NULL, 'Competitive team from Blantyre.', '3', 30, 1, '2026-05-21 13:47:06');
INSERT INTO teams (id, name, division, description, coach_id, max_players, is_active, created_at) VALUES (3, 'Zomba Zebras', NULL, 'Emerging talent from Zomba region.', NULL, 30, 1, '2026-05-21 13:47:06');

-- Players
INSERT INTO players (id, user_id, team_id, date_of_birth, gender, nationality, address, position, playing_experience, previous_clubs, emergency_contact_name, emergency_contact_phone, emergency_contact_relationship, registration_status, registration_notes, registered_at, reviewed_at, reviewed_by) VALUES (1, 4, '1', '1995-10-12', 'male', 'Malawian', 'Area 47, Lilongwe', 'forward', 5, '', 'Mary Mbewe', '+265888000111', '', 'approved', NULL, '2026-05-21 13:47:06', NULL, NULL);
INSERT INTO players (id, user_id, team_id, date_of_birth, gender, nationality, address, position, playing_experience, previous_clubs, emergency_contact_name, emergency_contact_phone, emergency_contact_relationship, registration_status, registration_notes, registered_at, reviewed_at, reviewed_by) VALUES (2, 5, '1', '1998-03-25', 'male', 'Malawian', 'Area 18, Lilongwe', 'Scrum-half', 3, NULL, 'John Nyirenda', '+265999111222', NULL, 'pending', NULL, '2026-05-21 13:47:06', NULL, NULL);
INSERT INTO players (id, user_id, team_id, date_of_birth, gender, nationality, address, position, playing_experience, previous_clubs, emergency_contact_name, emergency_contact_phone, emergency_contact_relationship, registration_status, registration_notes, registered_at, reviewed_at, reviewed_by) VALUES (3, 6, '2', '1992-07-08', 'male', 'Malawian', 'Namiwawa, Blantyre', 'Fly-half', 8, NULL, 'Sarah Chirwa', '+265888222333', NULL, 'approved', 'welcome to the team', '2026-05-21 13:47:06', NULL, NULL);
INSERT INTO players (id, user_id, team_id, date_of_birth, gender, nationality, address, position, playing_experience, previous_clubs, emergency_contact_name, emergency_contact_phone, emergency_contact_relationship, registration_status, registration_notes, registered_at, reviewed_at, reviewed_by) VALUES (4, 7, '2', '2000-11-30', 'male', 'Malawian', 'Chinyonga, Blantyre', 'Wing', 2, NULL, 'Peter Mwale', '+265999333444', NULL, 'rejected', NULL, '2026-05-21 13:47:06', NULL, NULL);
INSERT INTO players (id, user_id, team_id, date_of_birth, gender, nationality, address, position, playing_experience, previous_clubs, emergency_contact_name, emergency_contact_phone, emergency_contact_relationship, registration_status, registration_notes, registered_at, reviewed_at, reviewed_by) VALUES (5, 8, '3', '1997-01-14', 'male', 'Malawian', 'Mtiya, Zomba', 'Hooker', 4, NULL, 'Grace Kadzamira', '+265888444555', NULL, 'pending', NULL, '2026-05-21 13:47:06', NULL, NULL);

-- Coaches
INSERT INTO coaches (id, user_id, team_id, phone, address, date_of_birth, qualification, years_experience, coaching_specialty, registration_status) VALUES (1, 2, '1', '+265888123456', '', '1980-05-15', 'Level 2 World Rugby Coach', 10, 'Forwards Coach', 'approved');
INSERT INTO coaches (id, user_id, team_id, phone, address, date_of_birth, qualification, years_experience, coaching_specialty, registration_status) VALUES (2, 3, '2', NULL, NULL, '1975-08-22', 'Level 1 World Rugby Coach', 5, 'Backs Coach', 'approved');

-- Documents
INSERT INTO documents (id, user_id, document_type, file_name, original_filename, file_path, file_size, mime_type, verification_status, verified_by, verified_at, notes, uploaded_at) VALUES (1, 4, 'id_document', '', 'BIU UNDERGRADUATE APPLICATION FORM 2026.pdf', 'b4a55f5fca3324b425c8b555af92939a.pdf', 409341, 'application/pdf', 'verified', '1', '2026-05-21 17:54:55', '', '2026-05-21 16:42:30');

-- Notifications
INSERT INTO notifications (id, user_id, sender_id, title, message, type, target_type, target_id, is_read, created_at) VALUES (1, 5, '1', 'Registration Pending', 'Your registration is currently under review. Please ensure all documents are uploaded.', 'info', 'all', NULL, 0, '2026-05-21 13:47:06');
INSERT INTO notifications (id, user_id, sender_id, title, message, type, target_type, target_id, is_read, created_at) VALUES (2, 7, '1', 'Registration Rejected', 'Your registration has been rejected due to invalid medical clearance. Please upload a valid document.', 'error', 'all', NULL, 0, '2026-05-21 13:47:06');
INSERT INTO notifications (id, user_id, sender_id, title, message, type, target_type, target_id, is_read, created_at) VALUES (7, 0, '1', 'Welcome', 'Welcome to MARU', 'info', 'all', NULL, 0, '2026-05-21 18:22:24');

-- Posts
INSERT INTO posts (id, title, excerpt, body, image, author_id, is_published, published_at, created_at) VALUES (1, 'Welcome Message', 'Welcome to Maru\'s new site', 'We are happy to introduce this sight to our members and fans. You can now follow our activities through this page for it will be the first to give out any details regarding any events. Thank you.', '91bf1c9bbf28838057ff0dea3dd15064.jpg', 1, 1, '2026-05-21 16:53:14', '2026-05-21 18:40:49');

