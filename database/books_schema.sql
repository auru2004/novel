-- Detail skema tabel buku

-- Tabel Books
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author_id INT,
    genre_id INT,
    publication_year YEAR,
    isbn VARCHAR(20),
    description TEXT,
    rack_id INT,
    total_copies INT DEFAULT 1,
    available_copies INT DEFAULT 1,
    cover_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE SET NULL,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL,
    FOREIGN KEY (rack_id) REFERENCES racks(id) ON DELETE SET NULL
);

-- Index untuk performa
CREATE INDEX idx_books_title ON books(title);
CREATE INDEX idx_books_author ON books(author_id);
CREATE INDEX idx_books_genre ON books(genre_id);
CREATE INDEX idx_books_rack ON books(rack_id);