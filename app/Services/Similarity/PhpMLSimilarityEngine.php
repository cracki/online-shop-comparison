<?php

namespace App\Services\Similarity;

use App\Services\Similarity\Contracts\ProductSimilarityEngine;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Math\Distance\Euclidean;
use Phpml\Tokenization\WordTokenizer;

class PhpMLSimilarityEngine extends ProductSimilarityEngine
{
    public function calculateSimilarities(array $categoryA, array $categoryB): self
    {
        $coles_processed = $this->extractFeatures($categoryA);
        $woolworths_processed = $this->extractFeatures($categoryB);

        $all_texts = array_merge($coles_processed['features'], $woolworths_processed['features']);

        $vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $tfIdfTransformer = new TfIdfTransformer();

        $vectorizer->fit($all_texts);
        $vectorizer->transform($all_texts);

        $tfIdfTransformer->fit($all_texts);
        $tfIdfTransformer->transform($all_texts);

        $coles_vectors = array_slice($all_texts, 0, count($coles_processed['features']));
        $woolworths_vectors = array_slice($all_texts, count($coles_processed['features']));

        $euclidean = new Euclidean();
        $similar_products = [];

        foreach ($coles_vectors as $i => $coles_vector) {
            $similarities = [];

            foreach ($woolworths_vectors as $j => $woolworths_vector) {
                $distance = $euclidean->distance($coles_vector, $woolworths_vector);
                $similarity = 1 / (1 + $distance) * 100; // Convert similarity to percentage

                $similarities[] = [
                    'woolworths_id' => $woolworths_processed['labels'][$j],
                    'similarity' => round($similarity, 2), // Round to two decimal places
                ];
            }

            usort($similarities, function ($a, $b) {
                return $b['similarity'] <=> $a['similarity'];
            });

            $top_similarities = $similarities[0];

            $similar_products[] = [
                'product_a_id' => $coles_processed['labels'][$i],
                'product_b_id' => $top_similarities['woolworths_id'],
                'similarity' => $top_similarities['similarity']
            ];

            $this->similarities = $similar_products;
        }

        return $this;
    }
}
