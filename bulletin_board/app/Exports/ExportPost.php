<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportPost implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting, WithStrictNullComparison
{
  private $filter;

  public function __construct($filter = null)
  {
    $this->filter = $filter;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $query = Post::select("id", "title", "description", "status", "created_user_id", "updated_user_id","created_at", "updated_at");
    if ($this->filter) {
      $query->where('title', 'like', '%' . $this->filter . '%')
        ->orWhere('description', 'LIKE', '%' . $this->filter . '%');
    }
    return $query->get();
  }

  public function headings(): array
  {
    return ["id", "title", "description", "status", "created_user_id", "updated_user_id","created_at", "updated_at"];
  }

  // Select data from query and set its position
  public function map($post): array
  {
    // $deletedAtValue = $post->deleted_at ? Date::dateTimeToExcel($post->deleted_at) : null;
    return [
      $post->id,
      $post->title,
      $post->description,
      $post->status,
      $post->created_user_id,
      $post->updated_user_id,
      // $post->deleted_user_id,
      // $deletedAtValue,
      Date::dateTimeToExcel($post->created_at),
      Date::dateTimeToExcel($post->updated_at),
    ];
  }

  // Set Date Format
  public function columnFormats(): array
  {
    return [
      'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
      'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
      // 'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
    ];
  }
}
