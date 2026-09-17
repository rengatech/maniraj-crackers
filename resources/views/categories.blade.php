<!DOCTYPE html>
<html lang="ta">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Price List</title>
    <style>
        * {
            box-sizing: border-box;
        }   
        
        body, table, td, th {
            font-family: 'tamilfont', sans-serif !important;
            margin: 0;
            padding: 0;
        }

        body {
            padding: 10px;
        }

        .container {
            border: 3px solid #1a1a6e;
            padding: 5px;
        }

        .inner-container {
            border: 1px solid #1a1a6e;
            position: relative;
        }

        .header {
            text-align: center;
            padding: 32px 10px 15px;
            position: relative;
        }

       .logo {
            display: block;
            width: 100px;
            height: 100px;             /* 110 → 100, konjam sirusu pannitten */
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
            margin: 0 auto 0;          /* bottom margin 10px → 0, logo-க்கு கீழ peace kammi aagum */
         }

        .address-block {
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .contact-links {
            color: #1a1a6e;
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 4px;
        }

        .dealers {
            font-size: 10px;
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .cell-no {
            font-size: 14px;
            font-weight: bold;
            color: #cc0000;
            margin-bottom: 6px;
        }

        .price-list-title {
            font-size: 15px;
            font-weight: bold;
            color: #1a1a6e;
            margin-top: 8px;
            text-decoration: underline;
        }

        .validity-note {
            font-size: 10px;
            color: #cc0000;
            font-weight: bold;
            text-align: center;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            border-top: 2px solid #1a1a6e;
        }

        table, th, td {
            border: 1px solid #1a1a6e;
        }

        th, td {
            padding: 4px 2px;
            font-size: 9.5px;
            overflow: hidden;
        }

        .single-line {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th {
            background-color: #1a1a6e;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap;
        }

        td {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .category-heading {
            font-weight: bold;
            text-align: center;
            background-color: #cc0000;
            color: #ffffff;
            font-size: 11px;
        }
        
        .date-block {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 10px;
            font-weight: bold;
            color: #1a1a6e;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="inner-container">
            <div class="header">
                @php
                    $logoPath = public_path('assets/img/maniraj.logo.jpg');
                    if (file_exists($logoPath)) {
                        $logoData = base64_encode(file_get_contents($logoPath));
                    } else {
                        $logoData = '';
                    }
                @endphp
                @if($logoData)
                    <img src="data:image/jpeg;base64,{{ $logoData }}" alt="Maniraj Crackers Logo" class="logo">
                @endif
                
                <div class="date-block">Date : {{ date('d-m-Y') }}</div>
                
                <div class="address-block">
                    4/320, Sivakasi to  kazhugumalai main road naduvappatti. 627713
                </div>
                
                <div class="contact-links">
                    manirajcrackers.com // manirajshivani@gmail.com
                </div>

                <div class="dealers">
                    Dealers In All Kinds Of Crackers, Sparklers, Fancy Varieties & Gift Boxes -- Wholesale & Retail Sales
                </div>

                <div class="cell-no">
                    CELL NO : 9976739559,8248128425
                </div>

                <div class="price-list-title">
                    CUSTOMER PRICE LIST &mdash; {{ strtoupper(date('F Y')) }}
                </div>
            </div>

            <div class="validity-note">
                Note: This price list is valid only for 3 days from the date of generation.
            </div>

            <!-- Product Table -->
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">S.NO</th>
                        <th style="width: 28%;">CRACKERS NAME</th>
                        <th style="width: 12%;">UNITS</th>
                        <th style="width: 13%;">80% DISPRICE</th>
                        <th style="width: 6%;">QTY</th>
                        <th style="width: 11%;">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $slNo = 1;

                        $pdfProductOrder = [
                            1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 
                            21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 
                            39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, '51 B', 53, 54, 
                            55, 56, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 
                            74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 
                            92, 93, 94, 95, 96, 97, 98, 99, 100, 102, 103, 104, 105, 106, 107, 108, 
                            109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 
                            124, 125, '125A', 126, 127, 128, 129, 132, 133, 134, 135, 136, 137, 138, 
                            139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 
                            159, 160, 154, 157, 155, 156, 163, 162, 161
                        ];

                        $codeMap = array_flip($pdfProductOrder);

                        $categories = $categories->map(function ($category) use ($codeMap) {
                            $sortedProducts = $category->products->sortBy(function ($product) use ($codeMap) {
                                $code = $product->code ?? $product->product_code ?? $product->id;
                                return $codeMap[$code] ?? 999;
                            });

                            $category->setRelation('products', $sortedProducts);

                            $firstProduct = $sortedProducts->first();
                            $firstCode = $firstProduct ? ($firstProduct->code ?? $firstProduct->product_code ?? $firstProduct->id) : 0;
                            $category->first_order = $codeMap[$firstCode] ?? 999;

                            return $category;
                        })->sortBy('first_order')->values();
                    @endphp

                    @foreach($categories as $category)
                    <tr>
                        <td colspan="7" class="category-heading">{{ strtoupper($category->category) }}</td>
                    </tr>

                    @foreach($category->products as $product)
                    @php
                        $tamilName = $product->tamil_name ?? $product->name_ta ?? $product->ta_name ?? $product->name_tamil ?? $product->tamil ?? $product->description ?? '';
                        $units = $product->content ?? $product->unit ?? $product->packing ?? $product->units ?? $product->box_pkt ?? '';
                    @endphp
                    <tr>
                        <td class="text-center">{{ $slNo++ }}</td>
                        <td class="single-line">{{ $product->name }}</td>
                        <td class="text-center single-line">{{ $units }}</td>
                        <td class="text-center">{{ number_format($product->price, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>