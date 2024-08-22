<?php

namespace App\Exports;

use App\Models\ProductNameModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LiveStockExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $productLiveStock = new ProductNameModel();
        $data = $productLiveStock->exportLiveStock();
        return collect($data);
        
    }

    public function headings(): array
    {
        return [
            'SL.',
            'Product Name',
            'Product Unit',
            'Product Quantity',
            'Comment',
        ];
    }
}
