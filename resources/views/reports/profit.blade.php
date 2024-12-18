@extends('layouts.index')



@section('content')
    <h2 class="text-center mb-4">Laporan Laba per Bulan</h2>

    <!-- Tombol Download PDF -->
    <div class="text-end mb-3">
        <button id="downloadPdf" class="btn btn-success">Download PDF</button>
    </div>

    <!-- Tabel Laporan -->
    <div id="laporanTable">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Laba Penjualan</th>
            </tr>
            </thead>
            <tbody>
            @php $totalLaba = 0; @endphp
            @forelse($labaPerBulan as $key => $data)
                @php $totalLaba += $data->laba_penjualan; @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ DateTime::createFromFormat('!m', $data->bulan)->format('F') }}</td>
                    <td>{{ $data->tahun }}</td>
                    <td>{{ number_format($data->laba_penjualan, 0, ',', '.') }} IDR</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data tidak tersedia</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total Laba:</th>
                <th>{{ number_format($totalLaba, 0, ',', '.') }} IDR</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById("downloadPdf").addEventListener("click", function () {
            const laporan = document.getElementById("laporanTable");
            const opt = {
                margin: 0.5,
                filename: 'Laporan_Laba_PerBulan.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(laporan).set(opt).save();
        });
    </script>
@endsection
