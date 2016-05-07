<?php

declare (strict_types = 1);

namespace Phpml\SupportVectorMachine;

class DataTransformer
{
    /**
     * @param array $samples
     * @param array $labels
     *
     * @return string
     */
    public static function trainingSet(array $samples, array $labels): string
    {
        $set = '';
        $numericLabels = self::numericLabels($labels);
        foreach ($labels as $index => $label) {
            $set .= sprintf('%s %s %s', $numericLabels[$label], self::sampleRow($samples[$index]), PHP_EOL);
        }

        return $set;
    }

    /**
     * @param array $samples
     *
     * @return string
     */
    public static function testSet(array $samples): string
    {
        $set = '';
        foreach ($samples as $sample) {
            $set .= sprintf('0 %s %s', self::sampleRow($sample), PHP_EOL);
        }

        return $set;
    }

    /**
     * @param string $resultString
     * @param array  $labels
     *
     * @return array
     */
    public static function results(string $resultString, array $labels): array
    {
        $numericLabels = self::numericLabels($labels);
        $results = [];
        foreach (explode(PHP_EOL, $resultString) as $result) {
            $results[] = array_search($result, $numericLabels);
        }

        return $results;
    }

    /**
     * @param array $labels
     *
     * @return array
     */
    public static function numericLabels(array $labels): array
    {
        $numericLabels = [];
        foreach ($labels as $label) {
            if (isset($numericLabels[$label])) {
                continue;
            }

            $numericLabels[$label] = count($numericLabels);
        }

        return $numericLabels;
    }

    /**
     * @param array $sample
     *
     * @return string
     */
    private static function sampleRow(array $sample): string
    {
        $row = [];
        foreach ($sample as $index => $feature) {
            $row[] = sprintf('%s:%s', $index + 1, $feature);
        }

        return implode(' ', $row);
    }
}