<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Resource;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        User::create([
            'name' => 'Library Admin',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
        ]);

        // Categories
        $categories = [
            ['name' => 'Computer Science', 'slug' => 'computer-science', 'icon' => '💻', 'color' => '#6366f1'],
            ['name' => 'Mathematics', 'slug' => 'mathematics', 'icon' => '📐', 'color' => '#8b5cf6'],
            ['name' => 'Physics', 'slug' => 'physics', 'icon' => '⚛️', 'color' => '#06b6d4'],
            ['name' => 'Literature', 'slug' => 'literature', 'icon' => '📖', 'color' => '#f43f5e'],
            ['name' => 'Engineering', 'slug' => 'engineering', 'icon' => '⚙️', 'color' => '#f97316'],
            ['name' => 'Biology', 'slug' => 'biology', 'icon' => '🧬', 'color' => '#22c55e'],
            ['name' => 'History', 'slug' => 'history', 'icon' => '🏛️', 'color' => '#eab308'],
            ['name' => 'Philosophy', 'slug' => 'philosophy', 'icon' => '🤔', 'color' => '#a855f7'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Books
        $resources = [
            ['title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen', 'isbn' => '978-0262033848', 'type' => 'book', 'category_id' => 1, 'description' => 'A comprehensive textbook on algorithms, widely used in universities worldwide. Covers sorting, searching, graph algorithms, and advanced data structures.', 'published_year' => 2009, 'publisher' => 'MIT Press', 'pages' => 1312, 'rating' => 4.7, 'views' => 15420, 'total_copies' => 5, 'available_copies' => 3],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'isbn' => '978-0132350884', 'type' => 'book', 'category_id' => 1, 'description' => 'A handbook of agile software craftsmanship. Learn to write clean, readable, and maintainable code.', 'published_year' => 2008, 'publisher' => 'Prentice Hall', 'pages' => 464, 'rating' => 4.5, 'views' => 12300, 'total_copies' => 4, 'available_copies' => 2],
            ['title' => 'Design Patterns', 'author' => 'Gang of Four', 'isbn' => '978-0201633610', 'type' => 'book', 'category_id' => 1, 'description' => 'Elements of Reusable Object-Oriented Software. The classic book on software design patterns.', 'published_year' => 1994, 'publisher' => 'Addison-Wesley', 'pages' => 395, 'rating' => 4.6, 'views' => 9800, 'total_copies' => 3, 'available_copies' => 1],
            ['title' => 'The Art of Computer Programming', 'author' => 'Donald Knuth', 'isbn' => '978-0201896831', 'type' => 'book', 'category_id' => 1, 'description' => 'The bible of all fundamental algorithms and the work that taught many of today\'s software developers most of what they know.', 'published_year' => 1997, 'publisher' => 'Addison-Wesley', 'pages' => 672, 'rating' => 4.8, 'views' => 8900, 'total_copies' => 2, 'available_copies' => 2],
            ['title' => 'Artificial Intelligence: A Modern Approach', 'author' => 'Stuart Russell', 'isbn' => '978-0134610993', 'type' => 'book', 'category_id' => 1, 'description' => 'The leading textbook in Artificial Intelligence, used in over 1500 universities in 135 countries.', 'published_year' => 2020, 'publisher' => 'Pearson', 'pages' => 1115, 'rating' => 4.4, 'views' => 11200, 'total_copies' => 4, 'available_copies' => 3],
            ['title' => 'Calculus: Early Transcendentals', 'author' => 'James Stewart', 'isbn' => '978-1285741550', 'type' => 'book', 'category_id' => 2, 'description' => 'The most widely used calculus textbook. Clear explanations and comprehensive problem sets.', 'published_year' => 2015, 'publisher' => 'Cengage', 'pages' => 1368, 'rating' => 4.3, 'views' => 7600, 'total_copies' => 6, 'available_copies' => 4],
            ['title' => 'Linear Algebra Done Right', 'author' => 'Sheldon Axler', 'isbn' => '978-3319110790', 'type' => 'book', 'category_id' => 2, 'description' => 'A novel approach to linear algebra that focuses on the central idea of linear maps between vector spaces.', 'published_year' => 2014, 'publisher' => 'Springer', 'pages' => 340, 'rating' => 4.5, 'views' => 5400, 'total_copies' => 3, 'available_copies' => 2],
            ['title' => 'Principles of Quantum Mechanics', 'author' => 'R. Shankar', 'isbn' => '978-1475705782', 'type' => 'book', 'category_id' => 3, 'description' => 'A comprehensive treatment of quantum mechanics, ideal for graduate students and researchers.', 'published_year' => 2011, 'publisher' => 'Springer', 'pages' => 676, 'rating' => 4.6, 'views' => 4300, 'total_copies' => 3, 'available_copies' => 3],
            ['title' => 'Classical Mechanics', 'author' => 'Herbert Goldstein', 'isbn' => '978-0201657029', 'type' => 'book', 'category_id' => 3, 'description' => 'The classic graduate textbook on classical mechanics, covering Lagrangian and Hamiltonian formulations.', 'published_year' => 2001, 'publisher' => 'Addison-Wesley', 'pages' => 638, 'rating' => 4.4, 'views' => 3800, 'total_copies' => 2, 'available_copies' => 1],
            ['title' => 'One Hundred Years of Solitude', 'author' => 'Gabriel García Márquez', 'isbn' => '978-0060883287', 'type' => 'book', 'category_id' => 4, 'description' => 'The brilliant, bestselling, landmark novel that tells the story of the Buendía family and the town of Macondo.', 'published_year' => 1970, 'publisher' => 'Harper Perennial', 'pages' => 417, 'rating' => 4.8, 'views' => 14200, 'total_copies' => 5, 'available_copies' => 4],
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'isbn' => '978-0061120084', 'type' => 'book', 'category_id' => 4, 'description' => 'The unforgettable novel of a childhood in a sleepy Southern town and the crisis of conscience that rocked it.', 'published_year' => 1960, 'publisher' => 'Harper Perennial', 'pages' => 336, 'rating' => 4.7, 'views' => 18500, 'total_copies' => 6, 'available_copies' => 5],
            ['title' => '1984', 'author' => 'George Orwell', 'isbn' => '978-0451524935', 'type' => 'book', 'category_id' => 4, 'description' => 'A dystopian social science fiction novel and cautionary tale about the dangers of totalitarianism.', 'published_year' => 1949, 'publisher' => 'Signet Classic', 'pages' => 328, 'rating' => 4.7, 'views' => 22100, 'total_copies' => 7, 'available_copies' => 5],

            // Journals
            ['title' => 'Nature Machine Intelligence', 'author' => 'Various Authors', 'isbn' => '2522-5839', 'type' => 'journal', 'category_id' => 1, 'description' => 'A monthly journal covering machine learning, robotics, and AI research from Nature Publishing.', 'published_year' => 2024, 'publisher' => 'Nature Publishing', 'pages' => 120, 'rating' => 4.9, 'views' => 8900, 'total_copies' => 2, 'available_copies' => 2],
            ['title' => 'IEEE Transactions on Pattern Analysis', 'author' => 'IEEE', 'isbn' => '0162-8828', 'type' => 'journal', 'category_id' => 1, 'description' => 'Premier journal for computer vision, pattern recognition, and machine intelligence research.', 'published_year' => 2024, 'publisher' => 'IEEE', 'pages' => 200, 'rating' => 4.8, 'views' => 6700, 'total_copies' => 2, 'available_copies' => 1],
            ['title' => 'Physical Review Letters', 'author' => 'APS', 'isbn' => '0031-9007', 'type' => 'journal', 'category_id' => 3, 'description' => 'The world\'s premier physics letter journal, covering all areas of physics research.', 'published_year' => 2024, 'publisher' => 'American Physical Society', 'pages' => 150, 'rating' => 4.9, 'views' => 5400, 'total_copies' => 3, 'available_copies' => 3],

            // E-books
            ['title' => 'Deep Learning', 'author' => 'Ian Goodfellow', 'isbn' => '978-0262035613', 'type' => 'ebook', 'category_id' => 1, 'description' => 'The definitive textbook on deep learning, covering mathematical and conceptual backgrounds.', 'published_year' => 2016, 'publisher' => 'MIT Press', 'pages' => 800, 'rating' => 4.6, 'views' => 16800, 'total_copies' => 999, 'available_copies' => 999],
            ['title' => 'Python Data Science Handbook', 'author' => 'Jake VanderPlas', 'isbn' => '978-1491912058', 'type' => 'ebook', 'category_id' => 1, 'description' => 'Essential tools for working with data in Python. Covers IPython, NumPy, Pandas, Matplotlib, and Scikit-Learn.', 'published_year' => 2016, 'publisher' => 'O\'Reilly', 'pages' => 548, 'rating' => 4.4, 'views' => 13400, 'total_copies' => 999, 'available_copies' => 999],
            ['title' => 'The Elements of Statistical Learning', 'author' => 'Trevor Hastie', 'isbn' => '978-0387848570', 'type' => 'ebook', 'category_id' => 2, 'description' => 'Data Mining, Inference, and Prediction. A comprehensive reference for statistics and machine learning.', 'published_year' => 2009, 'publisher' => 'Springer', 'pages' => 745, 'rating' => 4.5, 'views' => 9200, 'total_copies' => 999, 'available_copies' => 999],

            // Research Papers
            ['title' => 'Attention Is All You Need', 'author' => 'Vaswani et al.', 'isbn' => 'arXiv:1706.03762', 'type' => 'research_paper', 'category_id' => 1, 'description' => 'The groundbreaking paper that introduced the Transformer architecture, revolutionizing natural language processing.', 'published_year' => 2017, 'publisher' => 'Google Brain', 'pages' => 15, 'rating' => 5.0, 'views' => 45000, 'total_copies' => 999, 'available_copies' => 999],
            ['title' => 'ImageNet Classification with Deep CNNs', 'author' => 'Alex Krizhevsky', 'isbn' => 'NIPS-2012', 'type' => 'research_paper', 'category_id' => 1, 'description' => 'The AlexNet paper that kicked off the deep learning revolution in computer vision.', 'published_year' => 2012, 'publisher' => 'NIPS', 'pages' => 9, 'rating' => 4.9, 'views' => 38000, 'total_copies' => 999, 'available_copies' => 999],

            // More variety
            ['title' => 'Sapiens: A Brief History of Humankind', 'author' => 'Yuval Noah Harari', 'isbn' => '978-0062316097', 'type' => 'book', 'category_id' => 7, 'description' => 'A groundbreaking narrative of humanity\'s creation and evolution exploring how biology and history shaped our understanding.', 'published_year' => 2015, 'publisher' => 'Harper', 'pages' => 443, 'rating' => 4.6, 'views' => 25600, 'total_copies' => 5, 'available_copies' => 3],
            ['title' => 'The Republic', 'author' => 'Plato', 'isbn' => '978-0140455113', 'type' => 'book', 'category_id' => 8, 'description' => 'Plato\'s masterwork on justice, the ideal state, and the nature of reality.', 'published_year' => -380, 'publisher' => 'Penguin Classics', 'pages' => 416, 'rating' => 4.5, 'views' => 12800, 'total_copies' => 4, 'available_copies' => 4],
            ['title' => 'Molecular Biology of the Cell', 'author' => 'Bruce Alberts', 'isbn' => '978-0393884821', 'type' => 'book', 'category_id' => 6, 'description' => 'The gold standard textbook for cell biology, covering molecular mechanisms of cell function.', 'published_year' => 2022, 'publisher' => 'W.W. Norton', 'pages' => 1464, 'rating' => 4.7, 'views' => 8700, 'total_copies' => 3, 'available_copies' => 2],
            ['title' => 'Fundamentals of Electric Circuits', 'author' => 'Charles Alexander', 'isbn' => '978-0078028229', 'type' => 'book', 'category_id' => 5, 'description' => 'A comprehensive introduction to electric circuits for engineering students.', 'published_year' => 2016, 'publisher' => 'McGraw-Hill', 'pages' => 992, 'rating' => 4.3, 'views' => 6500, 'total_copies' => 4, 'available_copies' => 3],
        ];

        foreach ($resources as $res) {
            Resource::create($res);
        }
    }
}
