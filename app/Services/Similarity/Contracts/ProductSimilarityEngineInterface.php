<?php
namespace App\Services\Similarity\Contracts;

interface ProductSimilarityEngineInterface
{
    public function processText(string $text): string;
    public function extractFeatures(array $products): array;
    public function calculateSimilarities(array $categoryA, array $categoryB): self;
    public function saveSimilarities(): self;
}
