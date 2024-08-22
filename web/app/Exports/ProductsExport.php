<?php

// ProductsExport.php

namespace App\Exports;

use App\Models\ProductNameModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $request = app('request');
        
        $productNameModel = new ProductNameModel();
        $data = $productNameModel->exportProductName($request);
        
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'SL.',
            'Product Name',
            'Unit',
            'Created At',
        ];
    }
}


