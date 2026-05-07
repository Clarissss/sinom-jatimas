<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice <?php echo e($invoice->invoice_number); ?></title>
    <style>
        /* RESET & BASE */
        @page {
            margin: 0px; /* Reset margin bawaan PDF */
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #374151;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        
        /* DEKORASI ATAS */
        .top-accent {
            background-color: #DD3517;
            height: 12px;
            width: 100%;
        }

        /* CONTAINER UTAMA */
        .container {
            padding: 40px 50px;
        }

        /* HEADER SECTION */
        .header-table {
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 20px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .company-name {
            font-size: 26px;
            font-weight: bold;
            color: #DD3517;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .company-tagline {
            font-size: 11px;
            color: #1f2937;
            font-weight: bold;
            margin-bottom: 6px;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .company-address {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.4;
        }
        .invoice-text {
            font-size: 38px;
            font-weight: 900;
            color: #111827;
            text-align: right;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 2px;
        }
        .invoice-meta {
            text-align: right;
            font-size: 11px;
            color: #4b5563;
            margin-top: 8px;
        }
        .invoice-meta strong {
            color: #111827;
            font-size: 12px;
        }

        /* INFO KLIEN & PROYEK (GRID) */
        .info-table {
            width: 100%;
            margin-bottom: 35px;
            border-collapse: separate;
            border-spacing: 15px 0; /* Jarak antar kotak */
            margin-left: -15px; /* Kompensasi spacing kiri */
        }
        .info-table td {
            vertical-align: top;
            width: 50%;
        }
        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 15px 20px;
        }
        .box-title {
            font-size: 10px;
            text-transform: uppercase;
            color: #DD3517;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            letter-spacing: 0.5px;
        }
        .box-content strong {
            color: #111827;
            font-size: 15px;
            display: block;
            margin-bottom: 5px;
        }
        .box-content p {
            margin: 3px 0;
            color: #4b5563;
            font-size: 11px;
        }

        /* TABEL ITEM INVOICE */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #1f2937;
            color: #ffffff;
            padding: 12px 10px;
            font-size: 10px;
            text-transform: uppercase;
            text-align: left;
            letter-spacing: 0.5px;
            border: 1px solid #1f2937;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            color: #1f2937;
        }
        .items-table tr:nth-child(even) td {
            background-color: #fcfcfc;
        }

        /* KALKULASI TOTAL */
        .total-wrapper {
            width: 100%;
        }
        .table-totals {
            width: 45%;
            float: right;
            border-collapse: collapse;
        }
        .table-totals td {
            padding: 10px 12px;
            text-align: right;
            border-bottom: 1px solid #e5e7eb;
        }
        .total-label {
            color: #4b5563;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .total-value {
            font-weight: bold;
            color: #111827;
        }
        .grand-total td {
            font-size: 16px;
            color: #DD3517;
            font-weight: 900;
            border-bottom: none;
            background-color: #fef2f2; /* Merah sangat muda */
            border-top: 2px solid #DD3517;
            padding: 15px 12px;
        }

        /* CLEARFIX UNTUK FLOAT */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* FOOTER & KETENTUAN */
        .footer-table {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }
        .footer-table td {
            vertical-align: bottom;
        }
        .terms-box {
            background-color: #f9fafb;
            border-left: 3px solid #DD3517;
            padding: 12px 15px;
            font-size: 10px;
            color: #4b5563;
            line-height: 1.6;
            width: 60%;
        }
        .signature-box {
            text-align: center;
            width: 40%;
        }
        .signature-title {
            color: #4b5563;
            margin-bottom: 10px;
        }
        .signature-space {
            height: 70px;
        }
        .signature-name {
            font-weight: bold;
            color: #111827;
            text-decoration: underline;
            font-size: 13px;
        }
        .signature-role {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }

        /* PAGE FOOTER */
        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            padding: 15px 0;
            border-top: 1px solid #f3f4f6;
            background-color: #ffffff;
        }
    </style>
</head>
<body>

    
    <div class="top-accent"></div>

    <div class="container">
        
        
        <table class="header-table">
            <tr>
                <td style="width: 60%;">
                    <h1 class="company-name">PT. SINOM JATI MAS</h1>
                    <p class="company-tagline">General Contractor & General Trading</p>
                    <p class="company-address">
                        Link. Sukarela RT/RW 006/001, Kel. Mekarsari, Kec. Pulomerak<br>
                        Email: sinomjatimas@gmail.com &nbsp;|&nbsp; Telp: 087771300570
                    </p>
                </td>
                <td style="width: 40%;">
                    <h2 class="invoice-text">INVOICE</h2>
                    <div class="invoice-meta">
                        Nomor: <strong><?php echo e($invoice->invoice_number); ?></strong><br>
                        Tanggal Terbit: <strong><?php echo e($invoice->created_at->format('d F Y')); ?></strong><br>
                        Termin Penagihan: <strong style="color: #DD3517;"><?php echo e($invoice->termin_percentage); ?>%</strong>
                    </div>
                </td>
            </tr>
        </table>

        
        <table class="info-table">
            <tr>
                <td>
                    <div class="info-box">
                        <div class="box-title">Ditagihkan Kepada:</div>
                        <div class="box-content">
                            <strong><?php echo e($invoice->project->client->name); ?></strong>
                            <p>Email: <?php echo e($invoice->project->client->email); ?></p>
                            <p>Telp: <?php echo e($invoice->project->client->phone ?? '-'); ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="info-box">
                        <div class="box-title">Detail Proyek:</div>
                        <div class="box-content">
                            <strong><?php echo e($invoice->project->name); ?></strong>
                            <p>Lokasi: <?php echo e($invoice->project->location ?? 'Sesuai Kontrak'); ?></p>
                            <p>Jatuh Tempo: <span style="color: #DD3517; font-weight: bold;"><?php echo e($invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d F Y') : 'Sesuai Perjanjian'); ?></span></p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 40%;">Uraian Pekerjaan / Barang</th>
                    <th style="width: 10%; text-align: center;">Qty</th>
                    <th style="width: 10%; text-align: center;">Sat</th>
                    <th style="width: 15%; text-align: right;">Harga (Rp)</th>
                    <th style="width: 20%; text-align: right;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="text-align: center;"><?php echo e($index + 1); ?></td>
                        <td><strong><?php echo e($item->item_name); ?></strong></td>
                        <td style="text-align: center;"><?php echo e(number_format($item->quantity, 1, ',', '')); ?></td>
                        <td style="text-align: center;"><?php echo e($item->unit); ?></td>
                        <td style="text-align: right;"><?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                        <td style="text-align: right; font-weight: bold;"><?php echo e(number_format($item->total, 0, ',', '.')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #9ca3af;">
                            <em>Rincian pekerjaan belum diisi.</em>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        
        <div class="total-wrapper clearfix">
            <table class="table-totals">
                <tr>
                    <td class="total-label">Subtotal</td>
                    <td class="total-value">Rp <?php echo e(number_format($invoice->amount, 0, ',', '.')); ?></td>
                </tr>
                <tr class="grand-total">
                    <td>TOTAL KESELURUHAN</td>
                    <td>Rp <?php echo e(number_format($invoice->amount, 0, ',', '.')); ?></td>
                </tr>
            </table>
        </div>

        
        <table class="footer-table">
            <tr>
                <td style="width: 60%; padding-right: 30px;">
                    <div class="terms-box">
                        <strong style="color: #111827;">Ketentuan Pembayaran:</strong><br>
                        1. Pembayaran disesuaikan dengan termin progres (<?php echo e($invoice->termin_percentage); ?>%).<br>
                        2. Mohon cantumkan Nomor Invoice pada berita transfer bank.<br>
                        3. Keterlambatan pembayaran dapat mengganggu jadwal progres di lapangan.
                    </div>
                </td>
                <td style="width: 40%;">
                    <div class="signature-box">
                        <div class="signature-title">Hormat Kami,</div>
                        <div style="font-weight: bold; font-size: 14px; color: #111827;">PT. SINOM JATI MAS</div>
                        
                        <div class="signature-space"></div>
                        
                        <div class="signature-name"><?php echo e($invoice->creator->name ?? 'Finance Dept.'); ?></div>
                        <div class="signature-role">Manajemen / Keuangan</div>
                    </div>
                </td>
            </tr>
        </table>

    </div>

    
    <div class="page-footer">
        Dokumen ini sah dan diterbitkan secara otomatis oleh Sistem Informasi PT. Sinom Jati Mas pada <?php echo e(now()->format('d F Y, H:i')); ?> WIB.
    </div>

</body>
</html><?php /**PATH /Users/ilyaskalamullah/Documents/SIP/sinom-jatimas/resources/views/pdf/invoice.blade.php ENDPATH**/ ?>