<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport {{ $student->name }} - Semester {{ $semester }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .student-info {
            width: 100%;
            margin-bottom: 20px;
        }
        .student-info td {
            padding: 3px 0;
            vertical-align: top;
        }
        .aspect-container {
            margin-bottom: 15px;
            page-break-inside: avoid; /* Mencegah paragraf terpotong di halaman baru */
        }
        .aspect-title {
            font-weight: bold;
            font-size: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .aspect-text {
            text-align: justify;
            margin: 0;
        }
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .signature {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature p {
            margin: 0;
        }
        .signature .space {
            height: 80px;
        }
        .signature .line {
            border-bottom: 1px solid #333;
            width: 100%;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Perkembangan Siswa PAUD</h1>
        <p>Tahun Ajaran {{ $student->classroom->school_year }}</p>
    </div>

    <table class="student-info">
        <tr>
            <td width="20%"><strong>Nama Siswa</strong></td>
            <td width="3%">:</td>
            <td width="77%">{{ $student->name }} ({{ $student->nickname }})</td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>:</td>
            <td>{{ $student->classroom->name }}</td>
        </tr>
        <tr>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td>{{ $semester }}</td>
        </tr>
    </table>

    <div class="content">
        @foreach($descriptions as $desc)
            <div class="aspect-container">
                <div class="aspect-title">{{ $desc->aspect->name }}</div>
                <p class="aspect-text">{{ $desc->final_text }}</p>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p>Guru Kelas</p>
            <div class="space"></div>
            <p><strong>(...................................)</strong></p>
        </div>
    </div>

</body>
</html>