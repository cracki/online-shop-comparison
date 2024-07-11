<?php
namespace App\Services\Similarity;

use App\Services\Similarity\Contracts\ProductSimilarityEngine;


class SimilarTextSimilarityEngine  extends ProductSimilarityEngine
{
    public function calculateSimilarities(array $categoryA, array $categoryB): self
    {
        $this->similarities = [];

        foreach ($categoryB as $productB) {
            $highest_similarity = 0;
            $closest_product = null;

            foreach ($categoryA as $productA) {
                $similarity_percentage = $this->calculateSimilarity(
                    $this->prepareText($productA),
                    $this->prepareText($productB)
                );

                if ($similarity_percentage > $highest_similarity) {
                    $highest_similarity = $similarity_percentage;
                    $closest_product = $productA['id'];
                }
            }

            $this->similarities[] = [
                'product_a_id' => $productB['id'],
                'product_b_id' => $closest_product,
                'similarity' => round($highest_similarity, 2),
            ];
        }

        return $this;
    }

    protected function calculateSimilarity(string $text1, string $text2): float
    {
        $processedText1 = $this->processText($text1);
        $processedText2 = $this->processText($text2);

        similar_text($processedText1, $processedText2, $similarity_percentage);

        return $similarity_percentage;
    }
}
