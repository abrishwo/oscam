<?php

namespace App\Imports;

use App\Models\Product;
use App\Services\QrCodeService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    protected $qrCodeService;

    public function __construct()
    {
        $this->qrCodeService = new QrCodeService();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = new Product([
            'product_name' => $row['product_name'],
            'batch_number' => $row['batch_number'],
            'status' => $row['status'],
        ]);

        $product->save();
        $product->qr_code = $this->qrCodeService->generate($product);
        $product->save();

        return $product;
    }
}
