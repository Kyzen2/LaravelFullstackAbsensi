<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Layanan Helpdesk - EduLog</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            margin: 0;
            padding: 40px;
            background-color: white;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .kop-surat h1 {
            margin: 0;
            font-weight: 900;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .kop-surat p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #555;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .title p {
            margin: 5px 0 0;
            font-size: 12px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-badge {
            font-weight: bold;
            text-transform: uppercase;
        }
        .signature-container {
            margin-top: 50px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 30%;
            text-align: center;
        }
        .signature-space {
            height: 80px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        
        @media print {
            @page { size: landscape; }
            body { padding: 0; }
            .no-print { display: none; }
        }
        
        .btn-print {
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <button onclick="window.print()" class="btn-print no-print">Cetak Dokumen (Print)</button>

    <div class="kop-surat">
        <h1>EDULOG</h1>
        <p>Laporan Rekapitulasi Pelayanan Keluhan Siswa (Helpdesk & SLA)</p>
    </div>

    <div class="title">
        <h2>DATA REKAPITULASI HELPDESK</h2>
        <p>Periode: {{ $periode }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Tiket</th>
                <th width="15%">Pelapor</th>
                <th width="20%">Subjek Aduan</th>
                <th width="10%">Prioritas</th>
                <th width="15%">Waktu Lapor</th>
                <th width="10%">Status</th>
                <th width="10%">Operator</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $index => $t)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td>#HLP-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $t->user->name ?? 'Unknown' }}</td>
                <td>{{ $t->subject }}</td>
                <td>{{ strtoupper($t->priority) }}</td>
                <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                <td class="status-badge">{{ strtoupper($t->status) }}</td>
                <td>{{ $t->operator->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding: 20px;">Tidak ada data tiket pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-container">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p><strong>Kepala Sekolah</strong></p>
            <div class="signature-space"></div>
            <p class="signature-name">( ........................................ )</p>
            <p>NIP: ................................</p>
        </div>
        <div class="signature-box">
            <p>Disiapkan Oleh,</p>
            <p><strong>Admin / Operator IT</strong></p>
            <div class="signature-space"></div>
            <p class="signature-name">{{ auth()->user()->name }}</p>
            <p>NIP: {{ auth()->user()->serial_number ?? '-' }}</p>
        </div>
    </div>

</body>
</html>
