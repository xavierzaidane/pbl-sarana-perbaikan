<?php

namespace App\Http\Controllers\DSS;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TOPSISController extends Controller
{
    public function calculate()
    {
        // Step 1: Get data from the database
        $alternatives = DB::table('alternative_topsis')->get();
        $criteria = DB::table('criteria_topsis')->get();
        $samplesRaw = DB::table('sample_topsis')->get();

        // Step 2: Format samples into decision matrix X
        $X = [];
        foreach ($alternatives as $alternative) {
            foreach ($criteria as $criterion) {
                $sample = $samplesRaw
                    ->where('id_alternative', $alternative->id_alternative)
                    ->where('id_criteria', $criterion->criteria_topsis_id)
                    ->first();
                $X[$alternative->id_alternative][$criterion->criteria_topsis_id] = $sample ? $sample->value : 0;
            }
        }

        // Step 3: Normalization matrix R
        $pembagi = [];
        foreach ($criteria as $criterion) {
            $sumSquares = 0;
            foreach ($alternatives as $alternative) {
                $val = $X[$alternative->id_alternative][$criterion->criteria_topsis_id];
                $sumSquares += pow($val, 2);
            }
            $pembagi[$criterion->criteria_topsis_id] = sqrt($sumSquares);
        }

        $R = [];
        foreach ($X as $id_alternatif => $a_kriteria) {
            foreach ($a_kriteria as $id_kriteria => $nilai) {
                $R[$id_alternatif][$id_kriteria] = $nilai / $pembagi[$id_kriteria];
            }
        }

        // Step 4: Weighted normalization matrix Y
        $Y = [];
        foreach ($R as $id_alternatif => $a_kriteria) {
            foreach ($a_kriteria as $id_kriteria => $nilai) {
                $weight = $criteria->firstWhere('criteria_topsis_id', $id_kriteria)->weight;
                $Y[$id_alternatif][$id_kriteria] = $nilai * $weight;
            }
        }

        // Step 5: Ideal solutions (A+ and A-)
        $A_max = [];
        $A_min = [];
        foreach ($criteria as $criterion) {
            $cid = $criterion->criteria_topsis_id;
            $column = array_column(array_map(function ($item) use ($cid) {
                return $item[$cid];
            }, $Y), null);
            $A_max[$cid] = max($column);
            $A_min[$cid] = min($column);
        }

        // Step 6: Distance to ideal solutions
        $D_plus = [];
        $D_min = [];
        foreach ($Y as $id_alternatif => $n_a) {
            $sum_plus = 0;
            $sum_min = 0;
            foreach ($n_a as $id_kriteria => $y) {
                $sum_plus += pow($y - $A_max[$id_kriteria], 2);
                $sum_min += pow($y - $A_min[$id_kriteria], 2);
            }
            $D_plus[$id_alternatif] = sqrt($sum_plus);
            $D_min[$id_alternatif] = sqrt($sum_min);
        }

        // Step 7: Preference values V
        $V = [];
        foreach ($D_min as $id_alternatif => $d_min) {
            $V[$id_alternatif] = $d_min / ($d_min + $D_plus[$id_alternatif]);
        }

        // Step 8: Ranking
        arsort($V);

        // Return data to the view
        return view('admin.table', [
            'alternatives' => $alternatives,
            'criteria' => $criteria,
            'results' => $V,
            'topAlternative' => $alternatives->firstWhere('id_alternative', key($V)),
            'preferenceValue' => reset($V)
        ]);
    }
}
