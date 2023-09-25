<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportPost implements FromCollection, WithHeadings,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Post::select("id","title", "description","status", "created_user_id", "updated_user_id", "deleted_user_id", "deleted_at", "created_at")->get();
    }

    public function headings(): array
    {
        return ["id","title", "description","status", "created_user_id", "updated_user_id", "deleted_user_id", "deleted_at", "created_at", "updated_at"];
    }
}
