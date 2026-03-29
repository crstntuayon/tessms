<?php

use Carbon\Carbon;

if (!function_exists('calculateAge')) {
    /**
     * Calculate age from birth date and optional reference date.
     *
     * @param string|null $birthDate
     * @param string|null $referenceDate
     * @return int|null
     */
    function calculateAge($birthDate, $referenceDate = null)
    {
        if (!$birthDate) {
            return null;
        }

        $birth = Carbon::parse($birthDate);
        $reference = $referenceDate ? Carbon::parse($referenceDate) : now();

        return $birth->diffInYears($reference);
    }
}