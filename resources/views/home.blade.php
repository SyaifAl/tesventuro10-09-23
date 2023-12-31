<!-- <?= var_dump($totalPerBulan);?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>


    <title>Laporan penjualan tahunan per menu</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="/home" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">

                                    <?php if(!isset($_GET['tahun'])) : ?>
                                        <option value="" selected>Pilih Tahun</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                    <?php endif; ?>

                                    <?php if(isset($_GET['tahun']) && $_GET['tahun'] == "") : ?>
                                        <option value="" selected>Pilih Tahun</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                    <?php endif; ?>

                                    <?php if(isset($_GET['tahun']) && $_GET['tahun'] == "2021") : ?>
                                        <option value="">Pilih Tahun</option>
                                        <option value="2021" selected>2021</option>
                                        <option value="2022">2022</option>
                                    <?php endif; ?>

                                    <?php if(isset($_GET['tahun']) && $_GET['tahun'] == "2022") : ?>
                                        <option value="">Pilih Tahun</option>
                                        <option value="2021">2021</option>
                                        <option value="2022" selected>2022</option>
                                    <?php endif; ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                            <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" rel="Array Menu" class="btn btn-secondary">
                                Json Menu
                            </a>
                            <a href="http://tes-web.landa.id/intermediate/transaksi?tahun=2021" target="_blank" rel="Array Transaksi" class="btn btn-secondary">
                                Json Transaksi
                            </a>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="margin: 0;">

                        <thead>
                            <tr class="table-dark">

                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                    @if (isset($_GET['tahun']) && $_GET['tahun'] != "")
                                        <!-- memilih tahun -->
                                        <th colspan="12" style="text-align: center;">Periode Pada  {{ ($_GET['tahun']) ? $tahun : '' }}
                                    @else
                                        <!-- tidak memilih -->
                                        <th colspan="12" style="text-align: center;">Periode Pada 
                                    @endif
                                </th>

                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>

                            </tr>
                            
                            <tr class="table-dark">
                                @foreach ($namaBulan as $val)
                                    <th style="text-align: center;width: 75px;">{{ $val['name'] }}</th> 
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            <!-- jika data ditemukan dan tahun tidak kosong -->
                            @if (isset($_GET['tahun']) && $_GET['tahun'] != "")

                                <tr>
                                    <td class="table-secondary" colspan="14"><b>Makanan</b></td>
                                </tr>

                                @foreach($makanan as $value)
                                    <tr>
                                        <td>{{ $value["makanan"] }}</td>
                                        @foreach($totalMenuPerBulan[$value["makanan"]] as $menu)
                                            <td style="text-align: right;">
                                                {{ number_format($menu["total"], 0, ',' , ',') }}
                                            </td>
                                        @endforeach
                                        <td style="text-align: right; font-weight: bold;">{{ number_format($totalMenuPerTahun[$value["makanan"]]["subtotal"], 0, ',' , ',') }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td class="table-secondary" colspan="14"><b>Minuman</b></td>
                                </tr>

                                @foreach($minuman as $value)
                                <tr>
                                    <td>{{ $value["minuman"] }}</td>
                                    @foreach($totalMenuPerBulan[$value["minuman"]] as $menu)
                                        <td style="text-align: right;">
                                            {{ number_format($menu["total"], 0, ',' , ',') }}
                                        </td>
                                    @endforeach
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($totalMenuPerTahun[$value["minuman"]]["subtotal"], 0, ',' , ',') }}</td>
                                </tr>
                                @endforeach

                                <tr class="table-dark">
                                    <td class="text-center">Total</td>
                                    @foreach($totalPerBulan as $total)
                                    <td style="text-align: right;">
                                        {{ number_format($total, 0, ',' , ',') }}
                                    </td>
                                    @endforeach
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($subTotal, 0, ',' , ',') }}</td>
                                </tr>

                            @else
                                <!-- jika tidak memilih tahun -->
                                <tr>
                                    <td colspan="14" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>