<?php

namespace App\Exports;

use App\Models\AuthUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AuthUser::where('is_admin', 0)->select('id', 'name', 'email', 'gender', 'phone')->get();
    }
    public function headings(): array
    {
        return ["ID", "Name", "Email", "Gender", "Phone"];
    }

    /*public function columnWidths(): array
    {
        return [
            'A' => 100,
            'B' => 100,
            'C' => 100,
            'D' => 100,
            'E' => 100
        ];
    }*/
}
