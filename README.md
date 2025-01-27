
# Inventory Management

## Overview
The Inventory Management project is designed to help manage and track inventory levels, orders, and stock. It includes features such as adding and removing items, updating inventory quantities, generating reports, and more.

## Modules
- Purchase module (add,edit or remove purchase)
- Ledger Module (add,edit or remove ledger for a suppliers)
- Product Module (add,edit product with their price & stock)
- Suppler Module (Manage supplier information)

## Getting Started

### Prerequisites
- Node.js and pnpm installed
- PHP ( >= 8.3) and Composer installed
- A database system (e.g., MySQL, SQLite)

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/inventory-management.git
   ```
2. Navigate to the project directory:
   ```bash
   cd inventory-management
   ```
3. Install the required dependencies:
   ```bash
   pnpm install
   ```
   ```bash
   composer install
   ```
4. Set up the environment variables by copying `.env.example` to `.env` and updating the necessary configurations.

5. Run the database migrations:
   ```bash
   php artisan migrate
   ```

### Running the Application
- Start the development server:
  ```bash
  pnpm run dev
  php artisan serve
  ```
- Alternatively, you can use:
  ```bash
  composer dev
  ```

## Usage
- Create some categories which will be used to create product
- Create Product with their price,stock and necessary information
- To manage supplier and his ledger supplier must be create first
- Associate a ledger to a supplier by creating a ledger

## Endpoints
| Web         | Api             |
|-------------|-----------------|
| /products   | /api/products   |
| /purchases  | /api/purchases  |
| /ledgers    | /api/ledgers    |
| /suppliers  | /api/suppliers  |
| /categories | /api/categories |

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments
- Mention any libraries, tools, or resources that were helpful in the development of this project.
