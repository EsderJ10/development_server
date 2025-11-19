<?php

class PlanGenerator
{
    public static function generatePlans($muscle, $weight, $repetitions)
    {
        $plans = [];

        $increment_conservative = $weight * 0.10;
        $increment_moderate = $weight * 0.20;
        $increment_aggressive = $weight * 0.30;

        $plans[] = [
            'name' => 'Conservative Plan',
            'description' => 'Gradual and sustainable increase',
            'target_weight' => round($weight + $increment_conservative, 1),
            'target_reps' => $repetitions + 2,
            'weeks' => 12,
            'intensity' => 'Low-Medium'
        ];

        $plans[] = [
            'name' => 'Moderate Plan',
            'description' => 'A perfect balance between progress and recovery',
            'target_weight' => round($weight + $increment_moderate, 1),
            'target_reps' => $repetitions + 4,
            'weeks' => 8,
            'intensity' => 'Medium-High'
        ];

        $plans[] = [
            'name' => 'Intensive Plan',
            'description' => 'Maximum progress in less time',
            'target_weight' => round($weight + $increment_aggressive, 1),
            'target_reps' => $repetitions + 5,
            'weeks' => 6,
            'intensity' => 'High'
        ];

        return $plans;
    }
}
