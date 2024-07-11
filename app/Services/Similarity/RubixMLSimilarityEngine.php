<?php

namespace App\Services\Similarity;

use App\Services\Similarity\Contracts\ProductSimilarityEngine;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\Transformers\TextNormalizer;
use Rubix\ML\Transformers\TfIdfTransformer;
use Rubix\ML\Transformers\TokenHashingVectorizer;

class RubixMLSimilarityEngine extends ProductSimilarityEngine
{
    public function calculateSimilarities(array $categoryA, array $categoryB): self
    {
        $coles_features = $this->extractFeatures($categoryA);
        $woolworths_features = $this->extractFeatures($categoryB);

        $coles_dataset = Labeled::build($coles_features['features'], $coles_features['labels']);
        $woolworths_dataset = Labeled::build($woolworths_features['features'], $woolworths_features['labels']);

        $transformers = [
            new TextNormalizer(),
            new TokenHashingVectorizer(1000),
            new TfIdfTransformer(),
        ];

        foreach ($transformers as $transformer) {
            $coles_dataset->apply($transformer);
            $woolworths_dataset->apply($transformer);
        }

        $euclidean = new Euclidean();
        $min_distance = INF;
        $max_distance = -INF;

        foreach ($woolworths_dataset->samples() as $i => $woolworths_sample) {
            foreach ($coles_dataset->samples() as $j => $coles_sample) {
                $distance = $euclidean->compute($woolworths_sample, $coles_sample);
                if ($distance < $min_distance) {
                    $min_distance = $distance;
                }
                if ($distance > $max_distance) {
                    $max_distance = $distance;
                }
            }
        }

        $similarities = [];
        foreach ($woolworths_dataset->samples() as $i => $woolworths_sample) {
            $closest_product = null;
            $min_distance = INF;

            foreach ($coles_dataset->samples() as $j => $coles_sample) {
                $distance = $euclidean->compute($woolworths_sample, $coles_sample);
                if ($distance < $min_distance) {
                    $min_distance = $distance;
                    $closest_product = $coles_dataset->label($j);
                }
            }

            $similarity_percentage = 100 * (1 - ($min_distance / $max_distance));
            $similarities[] = [
                'product_a_id' => $woolworths_dataset->label($i),
                'product_b_id' => $closest_product,
                'similarity' => round($similarity_percentage, 2),
            ];

            $this->similarities = $similarities;
        }

        return $this;
    }
}
