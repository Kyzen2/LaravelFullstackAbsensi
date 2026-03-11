<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'Helvetica', sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; text-transform: uppercase; font-size: 18px; }
        .info { margin-bottom: 20px; font-size: 11px; }
        .info table { width: 100%; }
        table.report { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
        table.report th, table.report td { border: 1px solid #000; padding: 6px; text-align: center; }
        table.report th { background-color: #f2f2f2; text-transform: uppercase; }
        table.report td.name { text-align: left; padding-left: 10px; }
        .footer { margin-top: 40px; }
        .signature { float: right; width: 200px; text-align: center; font-size: 11px; }
        .signature div { margin-top: 50px; border-top: 1px solid #000; padding-top: 5px; font-weight: bold; }
        .date-print { font-size: 9px; text-align: right; margin-top: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEHADIRAN SISWA</h1>
        <p style="margin: 5px 0; font-size: 12px;">RENTANG TANGGAL: {{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="100">Mata Pelajaran</td><td>: <strong>{{ strtoupper($jadwalInfo->mapel->nama_mapel) }}</strong></td>
                <td width="80">Kelas</td><td>: <strong>{{ strtoupper($jadwalInfo->kelas->nama_kelas) }}</strong></td>
            </tr>
            <tr>
                <td>Guru Pengampu</td><td>: <strong>{{ strtoupper($jadwalInfo->guru->nama_guru) }}</strong></td>
                <td>Tahun Ajaran</td><td>: <strong>{{ $jadwalInfo->kelas->tahunAjaran->tahun }} ({{ $jadwalInfo->kelas->tahunAjaran->semester }})</strong></td>
            </tr>
        </table>
    </div>

    <table class="report">
        <thead>
            <tr>
                <th width="25">No</th>
                <th class="name">Nama Siswa</th>
                <th width="40">Hadir</th>
                <th width="40">Sakit</th>
                <th width="40">Izin</th>
                <th width="40">Alpa</th>
                <th width="50">Total Sesi</th>
                <th width="60">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceData as $index => $data)
            @php 
                $percentage = $data['total_pertemuan'] > 0 ? round(($data['hadir'] / $data['total_pertemuan']) * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="name">{{ $data['nama'] }}</td>
                <td>{{ $data['hadir'] }}</td>
                <td>{{ $data['sakit'] }}</td>
                <td>{{ $data['izin'] }}</td>
                <td style="{{ $data['alpa'] > 0 ? 'color: #e11d48; font-weight: bold;' : '' }}">{{ $data['alpa'] }}</td>
                <td>{{ $data['total_pertemuan'] }}</td>
                <td style="font-weight: bold; {{ $percentage < 75 ? 'color: #e11d48;' : 'color: #10b981;' }}">
                    {{ $percentage }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="date-print">Dokumen ini dicetak pada: {{ now()->translatedFormat('d F Y H:i:s') }}</div>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p style="margin-top: -10px;">Guru Mata Pelajaran</p>
            <div>{{ strtoupper($jadwalInfo->guru->nama_guru) }}</div>
            <p style="font-size: 9px; font-weight: normal; margin-top: -5px; color: #666;">NIP. {{ $jadwalInfo->guru->nip }}</p>
        </div>
    </div>
</body>
</html>
