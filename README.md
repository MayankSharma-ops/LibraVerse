<<<<<<< HEAD
# 🌌 LibraVerse — Immersive Cinematic Library & Research Catalog

> **An advanced cognitive catalog built with physical animations, spatial WebGL soundscapes, and immersive dimensions.**

---

LibraVerse is a state-of-the-art interactive digital library application. By fusing a robust **Laravel 12** backend with high-end frontend technologies like **Three.js** and **GSAP**, LibraVerse turns cataloging and browsing into a cinematic, tactile experience. It is designed to demonstrate how a modern web interface can feel alive, responsive, and deeply premium.

---

## ✨ Primary Highlights & Interactions

### 1. WebGL 3D Archive Corridor

* Located at the bottom of the landing page, users embark on a scrolling journey down a virtual **Three.js** 3D corridor.
* Bookshelves line both sides of the screen, filled with randomly distributed, colorful volumes.
* Particle effects (dust motes) drift through the air while typography slides past as the user scrolls, mapping scroll percentage to camera depth ($z$-axis depth).
* Subtle parallax reacts to mouse movements to create a 3D orientation follow-effect.

### 2. Interactive 3D Storytelling Booklet

* A custom 3D CSS book structure turns pages sequentially as the user scrolls.
* Showcases core library methodologies (*Search, Filter, Analyze, Recommend, Explore*) across dynamic, beautifully animated panels.

### 3. Advanced Search Engine

* Offers multi-layer parameters including category filters, resource types (Books, Journals, E-books, Research Papers), and custom publishing year limits.
* Powered by AJAX queries that update results instantly without full page reloads.

### 4. Cinematic Aesthetics & Physics

* **Lenis Smooth Scroll:** Synchronized with the GSAP ticker for inertial scrolling control.
* **Preloader & Page Transitions:** A custom canvas overlay and dynamic book flapping animations that mask loading times.
* **Custom Cursor:** A dual-element custom magnetic cursor that morphs and glows depending on interactive hover states.
* **Tactile 3D Details:** Detail views include a 3D book cover that users can click to rotate in space.

---

## 🛠️ Technology Stack

| Layer                          | Technologies                                                                                      |
| :----------------------------- | :------------------------------------------------------------------------------------------------ |
| **Backend & Core**       | **Laravel 12** (PHP 8.2+), Eloquent ORM, Session/Cache SQLite Drivers                       |
| **Database**             | **SQLite** (Ideal for lightweight, lightning-fast self-contained deployments)               |
| **Styling**              | **Tailwind CSS v4** combined with curated vanilla CSS layers                                |
| **3D Rendering**         | **Three.js** (WebGL context, Custom Canvas textures for floating keywords)                  |
| **Animation Engines**    | **GSAP** (ScrollTrigger integration), **Anime.js**, **AOS** (Animate On Scroll) |
| **Utility & Smoothness** | **Lenis** (Inertial scrolling), **Axios** (Asynchronous API requests)                 |

---

## 📂 Key Directory Tour

* `app/Http/Controllers/`
  * `HomeController.php` — Retrieves statistical highlights, featured resource rankings, and categorizations.
  * `SearchController.php` — Handles AJAX pagination, parameters matching, and multi-tier filtering logic.
  * `ResourceController.php` — Manages detail profiles, tracks view increments, and fetches related recommendations.
  * `DashboardController.php` — Manages personal user account statistics (active borrowings, history list, recommended items) and seeds/logins a mock admin account automatically.
* `resources/js/animations/`
  * `corridorAnimation.js` — Custom Three.js render loop, camera setups, particle systems, and mouse tracking.
  * `preloader.js` — Timeline controls for page flapping transitions and exit sequences.
  * `bookScrollAnimation.js` — GSAP-linked page rotation triggers.
  * `cursorEffects.js` — Custom cursor tracking, cursor trail physics, and hover state scaling.
* `resources/views/`
  * `home.blade.php` — High-fidelity landing page containing the 3D book, parallax elements, and Three.js triggers.
  * `search.blade.php` — Comprehensive search interface with AJAX grid updates.
  * `dashboard.blade.php` — User statistics, current borrows list, borrowing history, and system recommendations.

---

## 🚀 Installation & Local Development

Getting the LibraVerse laboratory running locally takes just a few steps.

### Prerequisites

* **PHP >= 8.2**
* **Composer**
* **Node.js & npm**

### 1. Clone & Setup Configuration

Initialize the setup using the built-in Composer command script, which handles packages installation, environment copies, key generation, migrations, and assets building:

```bash
composer setup
```

Alternatively, if you prefer manual steps:

```bash
# Install PHP dependencies
composer install

# Copy environment template
cp .env.example .env

# Generate Application Security Key
php artisan key:generate

# Create SQLite Database File
touch database/database.sqlite

# Run Database Migrations and Seed mock records
php artisan migrate --seed

# Install NPM dependencies
npm install

# Build production assets
npm run build
```

### 2. Start the Development Environment

Run the concurrently integrated developer environment script:

```bash
composer dev
```

This single command fires up:

* **Laravel local server** (`php artisan serve`)
* **Vite Hot-Reload Server** (`npm run dev`)
* **Queue listeners** & **Pail logger**

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser to experience the application.

## 📄 License

The LibraVerse platform is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# LibraVerse
>>>>>>> ddda1a98b62ef2cd155084b4a93e04110bd20258
