<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Raport - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f8ef7;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #4f8ef7;
            margin: 0;
        }
        .info-siswa {
            margin-bottom: 30px;
            width: 100%;
        }
        .info-siswa td {
            padding: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN HASIL BELAJAR (RAPORT)</h1>
        <p>Tahun Ajaran 2024/2025</p>
    </div>

    <table class="info-siswa">
        <tr>
            <td width="30%"><strong>Nama Siswa</strong></td>
            <td>: {{ $siswa->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>NIS</strong></td>
            <td>: {{ $siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
                <th>Grade</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa->nilai as $index => $n)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $n->mataPelajaran->nama_mapel ?? '-' }}</td>
                <td>{{ $n->nilai }}</td>
                <td>
                    @php
                        if($n->nilai >= 85) echo 'A';
                        elseif($n->nilai >= 75) echo 'B';
                        elseif($n->nilai >= 60) echo 'C';
                        else echo 'D';
                    @endphp
                </td>
                <td>
                    @php
                        if($n->nilai >= 85) echo 'Sangat Baik';
                        elseif($n->nilai >= 75) echo 'Baik';
                        elseif($n->nilai >= 60) echo 'Cukup';
                        else echo 'Kurang';
                    @endphp
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada nilai</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p>Wali Kelas</p>
        <br><br>
        <p>(___________________)</p>
    </div>
</body>
</html>