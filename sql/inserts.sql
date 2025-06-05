INSERT INTO users (username, password, role)
VALUES
('admin01', '$2y$10$z6MPHEDbscCh0cW7XsLHPuTxv/hKMdrL1eFVoDKRkzFv/yWsvKoCi', 'admin'), -- password: admin123
('superadmin01', '$2y$10$6f1zUd.NUR2zZj3mTklD0uC2DK6UmsfnxCwz8Hhx0/6rULpguUG7a', 'super-admin'); -- password: super123

INSERT INTO categories (name)
VALUES
('Concert'),
('Exposition'),
('Conférence');

INSERT INTO events (title, description, price, start_date, end_date, time, category_id, created_by)
VALUES
('Rock à La Chaudière', 'Un concert énergique de rock indépendant.', 15.00, '2025-06-20', NULL, '20:30:00', 1, 1),
('Expo Photo Noir & Blanc', 'Une collection de photographies classiques.', 0.00, '2025-07-01', '2025-07-15', NULL, 2, 2),
('Conférence : Écologie et Climat', 'Présentation sur les enjeux écologiques actuels.', 5.00, '2025-06-22', NULL, '18:00:00', 3, 1);