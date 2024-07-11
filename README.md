# Price Comparison System

## Features

| Feature                              | Implemented |
|--------------------------------------|:-----------:|
| Design Patterns                      |      ✅      |
| Event Listener Implementation        |      ✅      |
| Service Provider Implementation      |      ✅      |
| Admin Panel and UI                   |      ✅      |
| Similarity Detection Service         |      ✅      |
| Link Generation and User Redirection |      ✅      |
| Unit Test                            |      ✅      |

## Project Overview

This Price Comparison System is a Laravel-based web application that allows users to compare product prices from two online stores and redirects them to the store with the lower price. The system includes user registration/login, product category display, price updates via background jobs, and user click tracking for analytics.

## Technical Architecture

The system's architecture follows these key steps:

1. Categories are defined in the admin panel.
2. Products are imported as JSON for each category.
3. After import, an event triggers the similarity detection process.

### Similarity Detection Engines

The system uses three similarity detection engines:

1. **Similarity Detection Based on Product Fields**: Uses algorithms from "Implementing the World's Best Algorithms" by Oliver (ISBN 0-131-00413-1) to calculate similarity percentages between products.

2. **Natural Language Processing (NLP) Techniques and Vector Space Models**: Leverages TF-IDF weighting and Euclidean distance in high-dimensional space to find semantic similarities between product descriptions.

3. **RubixML Engine**: Combines information retrieval, NLP, and machine learning techniques. It includes six main stages: Feature Extraction, Text Preprocessing, Vector Space Model, Distance Calculation, Similarity Scoring, and Nearest Neighbor Search.

## Installation

1. Clone the repository:
   
    ```git clone [repository-url]```
2. Install PHP dependencies:
   
    ```composer install```

3. Install and compile frontend dependencies:

    ```npm install```
    
    npm run build
4. Copy `.env.example` to `.env` and configure your environment variables.

5. Generate application key:
   
    ```php artisan key:generate```
6. Run database migrations:

   ```php artisan migrate```
7. Import sample data:
- Log in to the admin panel
- Navigate to the import section
- Import the following JSON files from the `storage` directory:
    - Coles-Fruit.json
    - Coles_Bakery.json
    - Woolworths-Fruit.json
    - Woolworths_Bakery.json

## Project Structure

Key components of the project:

- **Services**:
  - Generator
  - Similarity
  - ProductSyncService
  - RedirectToCheapestService


- **Service Provider**:
  - SimilarityEngineServiceProvider


- **Event**:
  - ProductsImported

## Running Tests

To run the unit tests:

```php artisan test```

## Future Development Ideas

1. Implement automatic product fetching from store websites for each category.
2. Develop nightly price and product information synchronization.
3. Add product image display or download functionality.
4. Synchronize category lists from main websites.
5. Create a system for adding new stores.
6. Implement separate access levels for customers and admins.
7. Generate reports on click counts per product or customer, with potential for commission or marketing features.
