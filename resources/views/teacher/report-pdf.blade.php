<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'Helvetica', sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 30px; }
        .header h1 { margin: 0; text-transform: uppercase; font-size: 20px; }
        .info { margin-bottom: 20px; font-size: 12px; }
        .info table { width: 100%; }
        table.report { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 11px; }
        table.report th, table.report td { border: 1px solid #000; padding: 8px; text-align: center; }
        table.report th { background-color: #f2f2f2; text-transform: uppercase; }
        table.report td.name { text-align: left; padding-left: 15px; }
        .footer { margin-top: 50px; }
        .signature { float: right; width: 200px; text-align: center; font-size: 12px; }
        .signature div { margin-top: 60px; border-top: 1px solid #000; padding-top: 5px; font-weight: bold; }
        .date { font-size: 10px; text-align: right; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Absensi Siswa Per Semester</h1>
        <p style="margin: 5px 0; font-size: 14px;">Tahun Ajaran {{ $jadwal->kelas->tahunAjaran->tahun }} - Semester {{ $jadwal->kelas->tahunAjaran->semester }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="100">Mata Pelajaran</td><td>: <strong>{{ $jadwal->mapel->nama_mapel }}</strong></td>
                <td width="100">Kelas</td><td>: <strong>{{ $jadwal->kelas->nama_kelas }}</strong></td>
            </tr>
            <tr>
                <td>Guru Pengampu</td><td>: <strong>{{ $jadwal->guru->nama_guru }}</strong></td>
                <td>Lokasi</td><td>: <strong>{{ $jadwal->lokasi->nama_lokasi }}</strong></td>
            </tr>
        </table>
    </div>

    <table class="report">
        <thead>
            <tr>
                <th width="30">No</th>
                <th class="name">Nama Siswa</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpha</th>
                <th>Total</th>
                <th>Presensi (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceData as $index => $data)
            @php 
                $total = $data['hadir'] + $data['sakit'] + $data['izin'] + $data['alpha'];
                $percentage = $data['total_pertemuan'] > 0 ? round(($data['hadir'] / $data['total_pertemuan']) * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="name">{{ $data['nama'] }}</td>
                <td>{{ $data['hadir'] }}</td>
                <td>{{ $data['sakit'] }}</td>
                <td>{{ $data['izin'] }}</td>
                <td style="{{ $data['alpha'] > 0 ? 'color: red;' : '' }}">{{ $data['alpha'] }}</td>
                <td>{{ $data['total_pertemuan'] }}</td>
                <td style="font-weight: bold;">{{ $percentage }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="date">Dicetak pada: {{ now()->format('d F Y H:i:s') }}</div>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p>Guru Mata Pelajaran</p>
            <div>{{ $jadwal->guru->nama_guru }}</div>
            <p style="font-size: 10px; font-weight: normal; margin-top: -5px;">NIP. {{ $jadwal->guru->nip }}</p>
        </div>
    </div>
</body>
</html>
