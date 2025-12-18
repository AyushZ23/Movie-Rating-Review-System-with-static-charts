-- =====================================================
-- Movie Rating & Review System - Database Schema
-- =====================================================
-- Create Database
-- =====================================================

-- Drop database if exists (clean slate)
DROP DATABASE IF EXISTS movie_review_system;

CREATE DATABASE movie_review_system
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE movie_review_system;

-- =====================================================
-- Create Movies Table
-- =====================================================

DROP TABLE IF EXISTS movies;

CREATE TABLE movies (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    movie_name VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    rating INT(1) NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review TEXT NOT NULL,
    reviewer VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_rating (rating),
    INDEX idx_genre (genre),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Insert Sample Data for Testing
-- =====================================================

INSERT INTO movies (movie_name, genre, rating, review, reviewer) VALUES
('The Shawshank Redemption', 'Drama', 5, 'An inspiring tale of hope and friendship. Absolutely brilliant storytelling and performances.', 'John Smith'),
('The Dark Knight', 'Action', 5, 'Heath Ledger\'s performance as the Joker is unforgettable. A masterpiece in the superhero genre.', 'Sarah Johnson'),
('Inception', 'Sci-Fi', 5, 'Mind-bending plot with stunning visuals. Christopher Nolan at his finest.', 'Michael Brown'),
('The Godfather', 'Crime', 5, 'The ultimate crime saga. Perfect in every aspect - acting, direction, and screenplay.', 'Emily Davis'),
('Forrest Gump', 'Drama', 4, 'Heartwarming story with an amazing performance by Tom Hanks. Life is like a box of chocolates!', 'David Wilson'),
('Interstellar', 'Sci-Fi', 4, 'Visually stunning space epic with emotional depth. The soundtrack is magnificent.', 'Lisa Anderson'),
('The Matrix', 'Action', 4, 'Revolutionary action sequences and philosophical themes. Redefined sci-fi cinema.', 'James Taylor'),
('Pulp Fiction', 'Crime', 5, 'Quentin Tarantino\'s non-linear masterpiece. Witty dialogue and unforgettable characters.', 'Jessica Martinez'),
('Titanic', 'Romance', 4, 'Epic romance on the ill-fated ship. Beautiful cinematography and moving performances.', 'Robert Garcia'),
('Avengers: Endgame', 'Action', 4, 'Satisfying conclusion to the Infinity Saga. Epic battles and emotional moments.', 'Amanda Rodriguez'),
('Parasite', 'Thriller', 5, 'Brilliant social commentary wrapped in a thrilling narrative. Deserved every award it won.', 'Christopher Lee'),
('The Lion King', 'Animation', 5, 'Timeless Disney classic with memorable songs and powerful story about courage and family.', 'Jennifer White'),
('Joker', 'Drama', 4, 'Joaquin Phoenix delivers a haunting performance. Dark and thought-provoking character study.', 'Matthew Harris'),
('Toy Story 3', 'Animation', 4, 'Emotional and beautifully crafted. Pixar at its best, making both kids and adults cry.', 'Ashley Clark'),
('The Silence of the Lambs', 'Thriller', 5, 'Psychological thriller that keeps you on edge. Hopkins and Foster are phenomenal.', 'Daniel Lewis');

-- =====================================================
-- Verification Queries
-- =====================================================

-- Check total movie count
SELECT COUNT(*) as total_movies FROM movies;

-- Check rating distribution
SELECT rating, COUNT(*) as count FROM movies GROUP BY rating ORDER BY rating;

-- Check genre distribution
SELECT genre, COUNT(*) as count FROM movies GROUP BY genre ORDER BY count DESC;

-- View all movies
SELECT * FROM movies ORDER BY created_at DESC;
