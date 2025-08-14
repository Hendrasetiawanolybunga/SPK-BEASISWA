<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Analisis Beasiswa</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
            padding: 20px;
        }
        
        .container {
            max-width: 1140px;
            margin: 0 auto;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 16px;
            color: #666;
        }
        
        /* Section */
        .section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 20px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        /* Table */
        .table-container {
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e9ecef;
        }
        
        /* Top 3 Styling */
        .rank-1 {
            background-color: rgba(255, 193, 7, 0.2);
            font-weight: bold;
        }
        
        .rank-2, .rank-3 {
            background-color: rgba(23, 162, 184, 0.1);
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
            color: #777;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        /* Print specific styles */
        @media print {
            body {
                padding: 0;
                font-size: 12pt;
            }
            
            .no-print {
                display: none;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            thead {
                display: table-header-group;
            }
            
            tfoot {
                display: table-footer-group;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Hasil Analisis Beasiswa</h1>
            <p>Sistem Pendukung Keputusan dengan Metode MOORA dan MAIRCA</p>
            <p>Tanggal: {{ date('d-m-Y') }}</p>
        </div>
        
        <!-- Bagian MOORA -->
        <div class="section">
            <h2 class="section-title">Ranking Metode MOORA</h2>
            <p>Metode Multi-Objective Optimization on the basis of Ratio Analysis (MOORA) digunakan untuk mengurutkan kandidat berdasarkan kriteria benefit dan cost.</p>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Alternatif</th>
                            <th>Skor Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($mooraProses['final_scores']) && count($mooraProses['final_scores']) > 0)
                            @php $rankNo = 1; @endphp
                            @foreach($mooraProses['final_scores'] as $alternative => $score)
                                @php
                                    $rowClass = '';
                                    if($rankNo == 1) $rowClass = 'rank-1';
                                    else if($rankNo <= 3) $rowClass = 'rank-' . $rankNo;
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td>{{ $rankNo++ }}</td>
                                    <td>{{ $alternative }}</td>
                                    <td>{{ number_format($score['final_score'], 6) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" style="text-align: center;">Tidak ada data yang tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Bagian MAIRCA -->
        <div class="section page-break">
            <h2 class="section-title">Ranking Metode MAIRCA</h2>
            <p>Metode Multi-Attributive Ideal-Real Comparative Analysis (MAIRCA) mengurutkan alternatif berdasarkan deviasi dari nilai ideal. Semakin kecil nilai deviasi, semakin baik peringkat alternatif.</p>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Alternatif</th>
                            <th>Skor Akhir (Deviasi)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($maircaProses['final_scores']) && count($maircaProses['final_scores']) > 0)
                            @php $rankNo = 1; @endphp
                            @foreach($maircaProses['final_scores'] as $alternative => $score)
                                @php
                                    $rowClass = '';
                                    if($rankNo == 1) $rowClass = 'rank-1';
                                    else if($rankNo <= 3) $rowClass = 'rank-' . $rankNo;
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td>{{ $rankNo++ }}</td>
                                    <td>{{ $alternative }}</td>
                                    <td>{{ number_format($score['final_deviation'], 6) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" style="text-align: center;">Tidak ada data yang tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="footer">
            <p>Dokumen ini dicetak dari Sistem Pendukung Keputusan Beasiswa</p>
        </div>
        
        <!-- Tombol Cetak (hanya tampil di browser) -->
        <div class="no-print" style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Cetak Dokumen
            </button>
        </div>
    </div>
    
    <script>
        // Auto print when page loads
        window.onload = function() {
            // Menunggu 1 detik sebelum memunculkan dialog cetak
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>
</html>