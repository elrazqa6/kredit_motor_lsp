<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .kwitansi {
            max-width: 700px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
            position: relative;
        }
        .stamp {
            position: absolute;
            bottom: 80px;
            right: 40px;
            font-size: 40px;
            font-weight: bold;
            color: #000;
            opacity: 0.3;
            transform: rotate(-15deg);
            border: 2px solid #000;
            padding: 5px 15px;
        }
        .text-center { text-align: center; }
        .mb-2 { margin-bottom: 10px; }
        .mb-4 { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #eee; }
        .total { text-align: right; font-size: 18px; font-weight: bold; }
        .footer { margin-top: 40px; display: flex; justify-content: space-between; }
        .ttd { text-align: center; width: 200px; }
        .ttd .line { margin-top: 40px; border-top: 1px solid #000; }
    </style>
</head>
<body>
    <div class="kwitansi">
        <div class="stamp">LUNAS</div>
        
        <div class="text-center mb-4">
            <h2>KREDIT MOTOR</h2>
            <p>Jl. Contoh No. 123, Jakarta Selatan</p>
            <p>Telp: 021-12345678</p>
            <hr>
            <h3>KWITANSI PEMBAYARAN</h3>
            <p>Angsuran Ke-{{ $angsuran->angsuran_ke }}</p>
        </div>
        
        <table>
            <tr>
                <td width="150"><strong>No. Kwitansi</strong></td>
                <td>: INV/{{ $angsuran->id }}/{{ date('Ymd') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: {{ \Carbon\Carbon::parse($angsuran->tgl_bayar)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Nama Pelanggan</strong></td>
                <td>: {{ $angsuran->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>: {{ $angsuran->kredit->pengajuanKredit->pelanggan->alamat1 ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Motor</strong></td>
                <td>: {{ $angsuran->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</td>
            </tr>
        </table>
        
        <table>
            <tr>
                <th>Deskripsi</th>
                <th width="150">Jumlah</th>
            </tr>
            <tr>
                <td>Pembayaran Angsuran Ke-{{ $angsuran->angsuran_ke }}</td>
                <td style="text-align: right">Rp {{ number_format($angsuran->total_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td style="text-align: right"><strong>Rp {{ number_format($angsuran->total_bayar, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
        
        <div class="footer">
            <div class="ttd">
                <div>Hormat Kami,</div>
                <div class="line"></div>
                <div>Admin</div>
            </div>
            <div class="ttd">
                <div>Penerima,</div>
                <div class="line"></div>
                <div>{{ $angsuran->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? 'Pelanggan' }}</div>
            </div>
        </div>
        
        <div class="text-center" style="margin-top: 20px; font-size: 10px;">
            Kwitansi ini adalah bukti sah pembayaran
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 20px;">
    <button onclick="window.print()" style="padding: 8px 20px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
        <i class="fas fa-print"></i> Cetak
    </button>
    <a href="{{ route('client.angsuran.index') }}" style="padding: 8px 20px; background: #64748b; color: white; text-decoration: none; border-radius: 5px;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>
    
    <script>
        // Auto print setelah 1 detik
        setTimeout(function() {
            window.print();
        }, 1000);
    </script>
</body>
</html>