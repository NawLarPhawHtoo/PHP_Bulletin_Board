<?php

namespace App\Imports;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ImportPost implements ToModel, WithHeadingRow, WithStartRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Post([
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => ($row['status'] === 0) ? 0 : $row['status'],
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id,
        ]);
    }

    public function startRow(): int
    {
        return 2; // Skip the header row
    }

    public function rules(): array
    {
        return [
            '*.title' => 'unique:posts,title,created_user_id',
        ];
    }
}
