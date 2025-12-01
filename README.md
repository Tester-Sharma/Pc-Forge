# � PCForge – Custom PC Builder

PCForge is a robust, web-based application designed to simplify the process of building a custom PC. It features a smart compatibility engine, real-time price calculation, and a sleek **Dark Mode** interface inspired by GitHub.

## 🚀 Features

### 👤 User Features
*   **Smart Builder**: Step-by-step selection (CPU → Motherboard → RAM → etc.) with automatic compatibility filters.
    *   *Example*: Selecting an Intel CPU automatically filters for compatible Motherboards.
*   **Real-Time Pricing**: Instantly updates total cost as you pick parts.
*   **Budget Tracker**: Set a budget and get visual warnings if you exceed it.
*   **User Accounts**: Register and Login using a unique **Username**.
*   **Save Builds**: Save your configurations to your profile for later viewing.
*   **PDF Export**: Generate a printer-friendly summary of your build.

### 🛡️ Admin Features
*   **Dashboard**: View quick statistics (Total Users, Parts, Builds).
*   **Inventory Management**: Full CRUD (Create, Read, Update, Delete) for hardware components.
*   **Dynamic Forms**: "Add Part" interface adapts based on the category (e.g., shows "Socket Type" for CPUs, "Wattage" for PSUs).

---

## �️ Technology Stack

*   **Frontend**: HTML5, CSS3 (Custom Dark Theme), JavaScript (Vanilla).
*   **Backend**: PHP (Core, No Framework).
*   **Database**: MySQL (PDO connection).
*   **Styling**: Custom CSS variables for a consistent dark theme (`#0d1117` background).

---

## ⚙️ Installation & Setup

1.  **Clone/Download** the repository to your server root (e.g., `htdocs/PcForge`).
2.  **Database Setup**:
    *   Create a database named `pcforge_db`.
    *   Import the `pcforge_schema.sql` file provided in the root directory.
3.  **Configuration**:
    *   Open `includes/db.php` and verify your database credentials (`localhost`, `root`, etc.).
4.  **Create Admin Account**:
    *   Insert an admin user directly into the database (Password must be hashed using `password_hash()`), or use a temporary script to generate one.
    *   *Default Table*: `admins` (username, password_hash).

---

## � Project Structure

```text
PcForge/
├─ admin/               # Admin Panel
│  ├─ dashboard.php     # Admin Home & Stats
│  ├─ parts-list.php    # View & Filter Parts
│  ├─ parts-add.php     # Add New Component
│  ├─ parts-edit.php    # Edit Component
│  └─ login.php         # Admin Login
├─ assets/
│  ├─ css/style.css     # Main Stylesheet (Dark Theme)
│  └─ js/builder.js     # Builder Logic (Compatibility & Pricing)
├─ includes/            # Reusable Components
│  ├─ db.php            # Database Connection
│  ├─ header.php        # Navbar & HTML Head
│  ├─ footer.php        # HTML Footer
│  └─ user-auth.php     # Auth Helper Functions
├─ builder.php          # Main PC Builder Interface
├─ index.php            # Landing Page
├─ login.php            # User Login (Username-based)
├─ register.php         # User Registration
├─ my-builds.php        # User's Saved Builds List
├─ export-pdf.php       # PDF Generation Logic
└─ pcforge_schema.sql   # Database Structure
```

## 🎨 Theme & Design

The project utilizes a **Dark Theme** color palette for a modern, developer-friendly look:

| Element | Color | Hex |
| :--- | :--- | :--- |
| **Background** | Dark Gray | `#0d1117` |
| **Header/Cards** | Darker Gray | `#161b22` |
| **Primary Accent** | Green | `#238636` |
| **Text Main** | Light Gray | `#c9d1d9` |
| **Text Muted** | Gray | `#8b949e` |

## � User Flow

1.  **Home**: Landing page with quick access to Builder.
2.  **Auth**: User registers with a **Username** and Password.
3.  **Build**:
    *   Enter Budget (Optional).
    *   Select CPU -> Motherboard (Filtered by Socket) -> RAM (Filtered by Type) -> etc.
4.  **Save**: Click "Save Build" to store it in the database.
5.  **Manage**: Go to "My Builds" to view history or export as PDF.

---

