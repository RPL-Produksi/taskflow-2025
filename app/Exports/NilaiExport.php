<?php

namespace App\Exports;

use App\Models\HasilTes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // <-- Tambah ini
use Maatwebsite\Excel\Concerns\WithTitle;    // <-- Optional, kasih judul sheet

class NilaiExport implements FromCollection, WithHeadings, WithTitle
{
    protected $tes_id;
    protected $tes_title;

    public function __construct($tes_id, $tes_title = 'Data Nilai')
    {
        $this->tes_id = $tes_id;
        $this->tes_title = $tes_title;
    }

    public function collection()
    {
        return HasilTes::with('user')
            ->where('tes_id', $this->tes_id)
            ->get()
            ->map(function ($nilai) {
                return [
                    'Nama' => $nilai->user->name,
                    'Nilai' => $nilai->nilai,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Nilai'
        ];
    }

    public function title(): string
    {
        return $this->tes_title;
    }
}
