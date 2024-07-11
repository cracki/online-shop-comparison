<?php

namespace App\Services\Similarity\Contracts;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class ProductSimilarityEngine implements ProductSimilarityEngineInterface
{
    protected array $similarities = [];

    public function getSimilarities(): array
    {
        return $this->similarities;
    }

    public function processText(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $words = explode(' ', $text);
        $words = array_filter($words, function ($word) {
            // Define additional stop words here
            $stopWords = ['the', 'and', 'for', 'with', 'pack', 'on', 'in', 'is', 'it', 'this', 'that'];

            // Check if the word length is greater than 2 and not in stop words
            return strlen($word) > 2 && !in_array($word, $stopWords);
        });
        return implode(' ', $words);
    }

    /**
     * Processes and prepares text for feature extraction.
     *
     * @param array $product
     * @param string $default
     * @return string|null
     */
    public function prepareText(array $product, string $default = ''): ?string
    {
        $textComponents = [
            $product['name'] ?? $default,
            $product['size'] ?? $default,
            $product['brand'] ?? $default,
            $product['description'] ?? $default,
            $product['category'] ?? $default,
        ];

        // Join components into a single string
        return implode(' ', $textComponents);
    }


    public function extractFeatures(array $products): array
    {
        $features = [];
        $labels = [];

        foreach ($products as $product) {
            $processedText = $this->prepareText($product);

            $features[] = $processedText;
            $labels[] = $product['id'];
        }

        return ['features' => $features, 'labels' => $labels];
    }

    abstract public function calculateSimilarities(array $categoryA, array $categoryB): self;

    public function saveSimilarities(): self
    {
        Log::info('saveSimilarities', ['engine_type' => static::class, 'similarities' => $this->similarities]);
        return $this;
        /*foreach ($this->similarities as $similarity) {
            DB::table('product_similarities')->insert([
                'product_a_id' => $similarity['product_a_id'],
                'product_b_id' => $similarity['product_b_id'],
                'similarity' => $similarity['similarity'],
                'engine_type' => static::class,
            ]);
        }*/
    }
}
