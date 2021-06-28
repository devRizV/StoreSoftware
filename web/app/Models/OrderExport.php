<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use DB;
class OrderExport implements FromCollection, WithHeadings
{

    use Exportable;
    protected $rows;

    public function __construct($data)
    {
        $this->rows = $data['products'];
    }

    public function collection()
    {


        $output = [];

        foreach ($this->rows as $row)
        {
            $output[] = [
                $row->prd_name,
                $row->prd_req_dep,
                $row->prd_qty,
                $row->prd_unit,
                $row->prd_qty_price,
                $row->prd_price,
                $row->prd_grand_price,
            ];
        }
        return collect($output);
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Requisation Department',
            'Product Qty',
            'Product Unit',
            'Proudct Qty Price',
            'Product Price',
            'Product Grand Price',
        ];
    }

    

 

    
}
