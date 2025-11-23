-- Data awal contoh untuk aplikasi Koleksi Buku Novel

-- Insert sample users
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'), -- password: password
('user1', 'user1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'), -- password: password
('user2', 'user2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'); -- password: password

-- Insert sample authors
INSERT INTO authors (name, biography, birth_date, nationality) VALUES
('Andrea Hirata', 'Andrea Hirata adalah seorang penulis Indonesia yang terkenal dengan novel "Laskar Pelangi"-nya.', '1971-05-26', 'Indonesia'),
('Tere Liye', 'Tere Liye adalah seorang penulis novel Indonesia yang dikenal dengan karyanya seperti "Bumi", "Bulan", dan "Matahari".', '1979-03-21', 'Indonesia'),
('Dewi Lestari', 'Dee atau Dewi Lestari adalah seorang penulis, musisi, dan aktris Indonesia.', '1980-12-06', 'Indonesia');

-- Insert sample genres
INSERT INTO genres (name, description) VALUES
('Fiksi', 'Cerita yang bersifat khayalan dan imajinatif'),
('Romansa', 'Cerita yang berfokus pada hubungan asmara'),
('Petualangan', 'Cerita yang penuh aksi dan penjelajahan'),
('Fantasi', 'Cerita yang mengandung unsur ajaib dan imajinatif'),
('Filsafat', 'Cerita yang mengandung pemikiran mendalam tentang kehidupan');

-- Insert sample racks
INSERT INTO racks (name, location, description) VALUES
('Rak Fiksi 1', 'Lantai 1, Sayap Barat', 'Rak untuk buku-buku fiksi'),
('Rak Romansa', 'Lantai 1, Sayap Timur', 'Rak khusus buku romansa'),
('Rak Anak-Anak', 'Lantai 2', 'Rak buku untuk anak-anak'),
('Rak Filsafat', 'Lantai 3', 'Rak untuk buku-buku filsafat dan pemikiran');

-- Insert sample books
INSERT INTO books (title, author_id, genre_id, publication_year, isbn, description, rack_id, total_copies, available_copies) VALUES
('Laskar Pelangi', 1, 1, 2005, '9789797805161', 'Sebuah novel yang menceritakan tentang sembilan anak dari keluarga miskin yang bersekolah di sebuah SD Muhammadiyah di Belitung.', 1, 5, 3),
('Bumi', 2, 4, 2014, '9786022200364', 'Novel petualangan yang mengisahkan tentang seorang anak bernama Raib yang tiba-tiba menguasai kekuatan elemen tanah.', 1, 4, 2),
('Supernova', 3, 1, 2002, '9793600631', 'Novel pertama dari trilogi Supernova yang menceritakan tentang seorang musisi jalanan bernama Keenan.', 1, 3, 1),
('Bulan', 2, 4, 2015, '9786022203969', 'Lanjutan dari novel Bumi, mengisahkan petualangan Raib dan kawan-kawan di dunia kelima.', 1, 4, 4),
('Filosofi Kopi', 1, 5, 2006, '97978056388', 'Kumpulan cerita pendek yang mengangkat tema kehidupan dan persahabatan melalui kisah dua pemuda yang membuka kedai kopi.', 4, 6, 5);

-- Insert sample lending records
INSERT INTO lending (user_id, book_id, borrow_date, due_date) VALUES
(2, 1, '2023-01-15', '2023-01-29'),
(3, 3, '2023-01-20', '2023-02-03'),
(2, 5, '2023-01-22', '2023-02-05');