<?php

namespace App\Services;

use App\Models\Rule;
use App\Models\Kerusakan;

class ForwardChainingService
{
    /**
     * Jalankan mesin inferensi forward chaining.
     * 
     * @param array $selectedGejalaIds Gejala yang dipilih oleh pengguna (teknisi).
     * @return Kerusakan|null Mengembalikan kerusakan jika ada rule yang cocok, atau null jika tidak ada.
     */
    public function diagnose(array $selectedGejalaIds): ?Kerusakan
    {
        if (empty($selectedGejalaIds)) {
            return null;
        }

        $rules = Rule::with('gejalas')->get();
        
        $matchedRule = null;
        $maxMatches = 0;

        foreach ($rules as $rule) {
            $ruleGejalaIds = $rule->gejalas->pluck('id')->toArray();
            
            if (empty($ruleGejalaIds)) {
                continue;
            }

            $isMatch = true;
            
            // Cek apakah semua gejala pada rule ini (IF) terdapat pada gejala yang dipilih teknisi
            foreach ($ruleGejalaIds as $id) {
                if (!in_array($id, $selectedGejalaIds)) {
                    $isMatch = false;
                    break;
                }
            }

            // Jika match, kita pilih rule dengan jumlah gejala terbanyak (paling spesifik)
            if ($isMatch) {
                if (count($ruleGejalaIds) > $maxMatches) {
                    $maxMatches = count($ruleGejalaIds);
                    $matchedRule = $rule;
                }
            }
        }

        return $matchedRule ? $matchedRule->kerusakan : null;
    }
}
